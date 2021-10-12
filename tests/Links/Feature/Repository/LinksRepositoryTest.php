<?php

declare(strict_types=1);

namespace Links\Feature\Repository;

use App\Modules\Links\Repository\LinksRepository;
use App\Modules\Links\Repository\Models\LinksModel;
use Database\Factories\LinksModelFactory;
use Database\Factories\LinksTagsModelFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\CreateApplicationTrait;

class LinksRepositoryTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /**
     * LinksRepository::fetchAllPaginated()
     * Fetch Active Links
     *
     * Setup 11 Active Links
     * Paginator left at default 10 records per page
     *
     * Expect Collection of 11 LinksModel
     * Expect Paginator Last page is 2
     * Check Paginator pages, recordsperpage
     */
    public function testFetchAllPaginated_ActiveLinks(): void
    {
        $expectTotal          = 11;
        $expectRecordsPerPage = 10;
        $expectLastPage       = 2;
        $repository           = new LinksRepository();
        LinksModelFactory::new()
            ->count(11)
            ->create();

        $results = $repository->fetchAllPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectLastPage, $results->lastPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertEquals($expectRecordsPerPage, $results->getCollection()->count());
        $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
    }

    /**
     * LinksRepository::fetchAllPaginated()
     * Check inactive links are not returned
     *
     * Setup 11 Inactive Links
     * Paginator left at default 10 records per page
     *
     * Expect Empty Collection
     * Expect Paginator Last page is 1
     * Check Paginator pages, recordsperpage
     */
    public function testFetchAllPaginated_InactiveLinks(): void
    {
        $expectTotal          = 0;
        $expectRecordsPerPage = 10;
        $expectLastPage       = 1;
        $repository           = new LinksRepository();
        LinksModelFactory::new()
            ->count(11)
            ->inactive()
            ->create();

        $results = $repository->fetchAllPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectLastPage, $results->lastPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertEmpty($results->getCollection());
    }

    /**
     * LinksRepository::fetchAllPaginated()
     * Should only return 'active' links
     *
     * Setup 11 Active Links
     * Setup 10 Inactive Links
     * Paginator left at default 10 records per page
     *
     * Expect Collection of 11 LinksModel
     * Expect Paginator Last page is 2
     * Check Paginator pages, recordsperpage
     */
    public function testFetchAllPaginated_ActiveAndInactiveLinks(): void
    {
        $expectTotal          = 11;
        $expectRecordsPerPage = 10;
        $expectLastPage       = 2;
        $repository           = new LinksRepository();
        LinksModelFactory::new()
            ->count(11)
            ->create();
        LinksModelFactory::new()
            ->count(10)
            ->inactive()
            ->create();

        $results = $repository->fetchAllPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectLastPage, $results->lastPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertEquals($expectRecordsPerPage, $results->getCollection()->count());
        $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
    }

    /**
     * LinksRepository::fetchAllPaginated()
     * No Links in database
     *
     * Expect paginator with empty collection
     * Expect Paginator Last page is 1
     * Check Paginator pages, recordsperpage
     */
    public function testFetchAllPaginated_NoLinksInDatabase(): void
    {
        $expectTotal          = 0;
        $expectRecordsPerPage = 10;
        $expectLastPage       = 1;
        $repository           = new LinksRepository();

        $results = $repository->fetchAllPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectLastPage, $results->lastPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertInstanceOf(Collection::class, $results->getCollection());
        $this->assertEmpty($results->getCollection());
    }

    /**
     * LinksRepository::fetchAllPaginated()
     * Test Paginator Setting
     *
     * Setup 11 Active Links
     * Paginator set at 1 records per page
     *
     * Expect paginator with empty collection
     * Expect Paginator Last page is 11
     * Check Paginator pages, recordsperpage
     */
    public function testFetchAllPaginated_TestPaginatorRecordsPerPage(): void
    {
        $expectTotal          = 11;
        $expectRecordsPerPage = 1;
        $expectLastPage       = 11;
        $repository           = new LinksRepository();
        LinksModelFactory::new()
            ->count(11)
            ->create();

        $results = $repository->fetchAllPaginated($expectRecordsPerPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectLastPage, $results->lastPage());
        $this->assertEquals($expectTotal, $results->total());
    }

    /**
     * LinksRepository::fetchByTagsPaginated()
     * Ensure that the link items match the tag
     *
     * Setup 1 tag with 2 related link records
     *
     * Expect 2 Links
     * Expect Paginator Last page is 1
     * Check Paginator pages, recordsperpage
     */
    public function testFetchByTagsPaginated_SingleTag(): void
    {
        $expectTotal          = 2;
        $expectRecordsPerPage = 10;
        $expectLastPage       = 1;
        $repository           = new LinksRepository();
        LinksTagsModelFactory::new()
            ->has(LinksModelFactory::new()->count(2), 'links')
            ->state(['name' => 'tagtest'])
            ->count(1)
            ->create();

        $results = $repository->fetchByTagsPaginated(['tagtest']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectLastPage, $results->lastPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertEquals($expectTotal, $results->getCollection()->count());
        $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
    }

    /**
     * LinksRepository::fetchByTagsPaginated()
     * Test Paginator Setting
     *
     * Paginator set at 1 records per page
     *
     * Expect 2 Links
     * Expect Paginator Last page is 1
     * Check Paginator pages, recordsperpage
     */
    public function testFetchByTagsPaginated_TestPaginatorRecordsPerPage(): void
    {
        $expectTotal          = 2;
        $expectRecordsPerPage = 1;
        $expectLastPage       = 2;
        $repository           = new LinksRepository();
        LinksTagsModelFactory::new()
            ->has(LinksModelFactory::new()->count(2), 'links')
            ->state(['name' => 'tagtest'])
            ->count(1)
            ->create();

        $results = $repository->fetchByTagsPaginated(['tagtest'], $expectRecordsPerPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectLastPage, $results->lastPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertEquals(1, $results->getCollection()->count());
        $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
    }

    /**
     * LinksRepository::fetchByTagsPaginated()
     * Ensure that the link items include ALL tags
     *
     * Setup tag-1 with 1 related link records
     * Setup tag-2 with 2 related link records
     * Setup tag-3 with 0 related link records
     *
     * Setup Paginator 1 records per page
     *
     * Expect - See Tests array below
     * Check Paginator pages, recordsperpage
     */
    public function testFetchByTagsPaginated_MultipleTags(): void
    {
        $expectRecordsPerPage = 1;
        $repository           = new LinksRepository();

        $links = LinksModelFactory::new()->count(2)->make();
        LinksTagsModelFactory::new()
            ->state(['name' => 'tag1'])
            ->count(1)
            ->create()->each(function ($tag) use ($links) {
                $tag->links()->save($links[0]);
            });
        LinksTagsModelFactory::new()
            ->state(['name' => 'tag2'])
            ->count(1)
            ->create()->each(function ($tag) use ($links) {
                $tag->links()->save($links[0]);
                $tag->links()->save($links[1]);
            });
        LinksTagsModelFactory::new()
            ->state(['name' => 'tag3'])
            ->count(1)
            ->create();

        $tests = [
            ['expectTotal' => 1, 'tags' => ['tag1']],
            ['expectTotal' => 1, 'tags' => ['tag1', 'tag2']],
            ['expectTotal' => 2, 'tags' => ['tag2']],
            ['expectTotal' => 0, 'tags' => ['tag3']],
        ];

        foreach ($tests as $test) {
            $expectTotal = $test['expectTotal'];
            $results     = $repository->fetchByTagsPaginated($test['tags'], $expectRecordsPerPage);
            $this->assertInstanceOf(LengthAwarePaginator::class, $results);
            $this->assertEquals($expectRecordsPerPage, $results->perPage());
            $this->assertEquals($expectTotal, $results->total());
            if ($expectTotal > 0) {
                $this->assertEquals($expectRecordsPerPage, $results->getCollection()->count());
                $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
            }
        }
    }
}
