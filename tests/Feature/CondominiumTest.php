<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Block;
use App\Models\Condominium;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Visit;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * @property Condominium condominium
 * @property Block blockA
 * @property Block blockB
 * @property Tenant tenant
 */
class CondominiumTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createCondominium();
    }

    /**
     * @test
     */
    public function condominiumsHaveBlocksAndUnits(): void
    {
        $blocks = $this->condominium->blocks;

        self::assertCount(2, $blocks);
        self::assertTrue($this->blockA->is($blocks->first()));
        self::assertTrue($this->blockB->is($blocks->last()));

        self::assertCount(4, $blocks->pluck('units')->collapse());
    }

    /**
     * @test
     */
    public function unitsMightHaveTenants(): void
    {
        $units = $this->blockA->units;

        /** @var Unit $unitA */
        $unitA = $units->first();
        /** @var Unit $unitB */
        $unitB = $units->last();

        $unitA->rent($this->tenant);

        self::assertNull($unitB->tenant);
        self::assertTrue($unitA->fresh()->tenant->is($this->tenant));
    }

    /**
     * @test
     */
    public function unitsKnowAboutTheirVisitors(): void
    {
        $now = CarbonImmutable::now();

        $unitA = $this->blockA->units->first();
        $unitB = $this->blockA->units->last();

        Visit::factory()->create([
            'condominium_id' => $this->condominium->id,
            'block_id' => $this->blockA->id,
            'unit_id' => $unitA->id,
            'arrived_at' => $now,
            'left_at' => $now->addHours(2),
        ]);

        Visit::factory()->create([
            'condominium_id' => $this->condominium->id,
            'block_id' => $this->blockA->id,
            'unit_id' => $unitA->id,
            'arrived_at' => $now,
        ]);

        Visit::factory()->create([
            'condominium_id' => $this->condominium->id,
            'block_id' => $this->blockA->id,
            'unit_id' => $unitB->id,
            'arrived_at' => $now,
            'left_at' => $now->addHours(2),
        ]);

        tap($unitA->fresh(), static function (Unit $unit) {
            self::assertCount(2, $unit->visits);
            self::assertCount(1, $unit->getCurrentVisitors());
        });

        tap($unitB->fresh(), static function (Unit $unit) {
            self::assertCount(1, $unit->visits);
            self::assertCount(0, $unit->getCurrentVisitors());
        });

        tap(Visit::all(), function (Collection $visits) use ($unitA, $unitB) {
            self::assertTrue($visits->first()->unit->is($unitA));
            self::assertTrue($visits->first()->block->is($this->blockA));

            self::assertTrue($visits[1]->unit->is($unitA));
            self::assertTrue($visits[1]->block->is($this->blockA));

            self::assertTrue($visits->last()->unit->is($unitB));
            self::assertTrue($visits->last()->block->is($this->blockA));
        });
    }

    private function createCondominium(): void
    {
        $this->condominium = Condominium::factory()->create();

        $this->blockA = Block::factory()->create(['condominium_id' => $this->condominium->id]);
        $this->blockB = Block::factory()->create(['condominium_id' => $this->condominium->id]);

        Unit::factory()->count(2)->create([
            'condominium_id' => $this->condominium->id,
            'block_id' => $this->blockA->id,
        ]);

        Unit::factory()->count(2)->create([
            'condominium_id' => $this->condominium->id,
            'block_id' => $this->blockB->id,
        ]);

        $this->tenant = Tenant::factory()->create();
    }
}
