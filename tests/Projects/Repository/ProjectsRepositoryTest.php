<?php

declare(strict_types=1);

namespace Links\Feature\Repository;

use App\Modules\Projects\Repository\Models\ProjectsModel;
use App\Modules\Projects\Repository\ProjectsRepository;
use Database\Factories\ProjectsModelFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class ProjectsRepositoryTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /**
     * ProjectsRepository::fetchAllProjects()
     * Fetch Active Projects
     *
     * Setup 10 Active Projects
     *
     * Expect Collection of 10 ProjectsModel
     */
    public function testFetchAllProjects_ActiveProjects(): void
    {
        $expectTotal = 10;
        $repository  = new ProjectsRepository();
        ProjectsModelFactory::new()
            ->count(10)
            ->create();

        $results = $repository->fetchAllProjects();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertInstanceOf(ProjectsModel::class, $results->getIterator()[0]);
    }

    /**
     * ProjectsRepository::fetchAllProjects()
     * Check inactive projects are not returned
     *
     * Setup 10 Inactive Projects
     *
     * Expect Empty Collection
     */
    public function testFetchAllProjects_InactiveProjects(): void
    {
        $expectTotal = 0;
        $repository  = new ProjectsRepository();
        ProjectsModelFactory::new()
            ->count(10)
            ->inactive()
            ->create();

        $results = $repository->fetchAllProjects();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertEmpty($results->getIterator());
    }

    /**
     * ProjectsRepository::fetchAllProjects()
     * No Projects in database
     *
     * Expect empty collection
     */
    public function testFetchAllProjects_NoLinksInDatabase(): void
    {
        $expectTotal = 0;
        $repository  = new ProjectsRepository();

        $results = $repository->fetchAllProjects();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertEmpty($results->getIterator());
    }

    /**
     * ProjectsRepository::fetchAllProjects()
     * Ensure that only active projects are returned
     *
     * Setup 10 projects active
     * Setup 10 projects inactive
     *
     * Expect 10 Project Items
     */
    public function testFetchAllProjects_OnlyFetchActive(): void
    {
        $expectTotal = 10;
        $repository  = new ProjectsRepository();
        ProjectsModelFactory::new()
            ->count(10)
            ->create();
        ProjectsModelFactory::new()
            ->count(10)
            ->inactive()
            ->create();

        $results = $repository->fetchAllProjects();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertInstanceOf(ProjectsModel::class, $results[0]);
    }
}
