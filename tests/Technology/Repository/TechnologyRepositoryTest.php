<?php

declare(strict_types=1);

namespace Links\Feature\Repository;

use App\Modules\Technology\Repository\Models\TechnologyItemsModel;
use App\Modules\Technology\Repository\Models\TechnologyModel;
use App\Modules\Technology\Repository\TechnologyRepository;
use Database\Factories\TechnologyItemsModelFactory;
use Database\Factories\TechnologyModelFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class TechnologyRepositoryTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /**
     * TechnologyRepository::fetchAllTechnologies()
     * Fetch Active Technologies
     *
     * Setup 11 Active Technologies
     *
     * Expect Collection of 11 LinksModel
     */
    public function testFetchAllPaginated_ActiveLinks(): void
    {
        $expectTotal = 11;
        $repository  = new TechnologyRepository();
        TechnologyModelFactory::new()
            ->count(11)
            ->create();

        $results = $repository->fetchAllTechnologies();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertInstanceOf(TechnologyModel::class, $results->getIterator()[0]);
    }

    /**
     * TechnologyRepository::fetchAllTechnologies()
     * Check inactive technologies are not returned
     *
     * Setup 11 Inactive Technologies
     *
     * Expect Empty Collection
     */
    public function testFetchAllPaginated_InactiveLinks(): void
    {
        $expectTotal = 0;
        $repository  = new TechnologyRepository();
        TechnologyModelFactory::new()
            ->count(11)
            ->inactive()
            ->create();

        $results = $repository->fetchAllTechnologies();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertEmpty($results->getIterator());
    }

    /**
     * TechnologyRepository::fetchAllTechnologies()
     * Should only return 'active' technologies
     *
     * Setup 11 Active Technologies
     * Setup 10 Inactive Technologies
     *
     * Expect Collection of 11 TechnologyModel
     */
    public function testFetchAllTechnologies_ActiveAndInactiveLinks(): void
    {
        $expectTotal = 11;
        $repository  = new TechnologyRepository();
        TechnologyModelFactory::new()
            ->count(11)
            ->create();
        TechnologyModelFactory::new()
            ->count(10)
            ->inactive()
            ->create();

        $results = $repository->fetchAllTechnologies();

        $this->assertEquals($expectTotal, $results->count());
        $this->assertInstanceOf(TechnologyModel::class, $results->getIterator()[0]);
    }

    /**
     * TechnologyRepository::fetchAllTechnologies()
     * No Links in database
     *
     * Expect empty collection
     */
    public function testFetchAllTechnologies_NoLinksInDatabase(): void
    {
        $expectTotal = 0;
        $repository  = new TechnologyRepository();

        $results = $repository->fetchAllTechnologies();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertEmpty($results->getIterator());
    }

    /**
     * TechnologyRepository::fetchAllTechnologies()
     * Ensure that the technology items are returned
     *
     * Setup 1 item with 2 related technology records
     *
     * Expect 2 Technology Items
     */
    public function testFetchByTechnologies_CheckItems(): void
    {
        $expectTotalTechnology      = 1;
        $expectTotalTechnologyItems = 2;
        $repository                 = new TechnologyRepository();
        TechnologyModelFactory::new()
            ->has(TechnologyItemsModelFactory::new()->count(2), 'items')
            ->has(TechnologyItemsModelFactory::new()->inactive()->count(2), 'items')
            ->count(1)
            ->create();

        $results = $repository->fetchAllTechnologies();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotalTechnology, $results->count());
        $this->assertInstanceOf(TechnologyModel::class, $results[0]);

        $this->assertEquals($expectTotalTechnologyItems, $results[0]['items']->count());
        $this->assertInstanceOf(TechnologyItemsModel::class, $results[0]['items'][0]);
    }
}
