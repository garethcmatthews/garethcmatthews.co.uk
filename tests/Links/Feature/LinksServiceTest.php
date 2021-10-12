<?php

declare(strict_types=1);

namespace Links\Feature;

use App\Modules\Links\Exceptions\PageNotFoundException;
use App\Modules\Links\LinksService;
use App\Modules\Links\Repository\Models\LinksModel;
use Database\Factories\LinksModelFactory;
use Database\Factories\LinksTagsModelFactory;
use Illuminate\Cache\CacheManager;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\CreateApplicationTrait;

class LinksServiceTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    private const RECORDS_PER_PAGE = 'modules.links.paginator-records-per-page';

    /**
     * LinksService::fetchAll()
     * Fetch Active Links
     *
     * Expect Collection of 11 LinksModel
     * Expect Paginator Last page is 2
     * Check Paginator pages, recordsperpage
     */
    public function testFetchAll(): void
    {
        $expectTotal          = 11;
        $expectRecordsPerPage = 10;

        $service = $this->app->get(LinksService::class);
        LinksModelFactory::new()
            ->count(11)
            ->create();

        $results = $service->fetchAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());

        $this->assertEquals($expectTotal, $results->total());
        $this->assertEquals($expectRecordsPerPage, $results->getCollection()->count());
        $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
    }

    /**
     * LinksService::fetchAll()
     * Fetch Active Links - Test Paginator
     *
     * Expect Collection of 11 LinksModel
     * Expect Paginator records per page is 1
     * Expect Paginator Last page is 11
     * Check Paginator pages, recordsperpage
     */
    public function testFetchAll_TestPaginator(): void
    {
        $expectTotal          = 11;
        $expectRecordsPerPage = 1;
        $expectLastPage       = 11;

        $this->app->get('config')->set(self::RECORDS_PER_PAGE, $expectRecordsPerPage);
        $service = $this->app->get(LinksService::class);
        LinksModelFactory::new()
            ->count(11)
            ->create();

        $results = $service->fetchAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectLastPage, $results->lastPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertEquals($expectRecordsPerPage, $results->getCollection()->count());
        $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
    }

    /**
     * LinksService::fetchAll()
     * Fetch Active Links
     * Test paginator going out of range throws exception
     *
     * Expect Exception
     */
    public function testFetchAll_TestPaginatorOutOfRangeThrowsException(): void
    {
        $service = $this->app->get(LinksService::class);
        LinksModelFactory::new()
            ->count(1)
            ->create();

        $this->expectException(PageNotFoundException::class);
        $service->fetchAll(2);
    }

    /**
     * LinksService::fetchAll()
     * Check that the cache is called
     */
    public function testFetchAll_CacheIsCalled(): void
    {
        $paginator = $this->createStub(LengthAwarePaginator::class);
        $mock      = $this->getMockBuilder(CacheManager::class)
            ->disableOriginalConstructor()
            ->addMethods(['remember'])
            ->getMock();
        $mock->expects($this->once())->method('remember')
            ->with()
            ->willReturn($paginator);
        $this->instance('cache', $mock);

        $service = $this->app->get(LinksService::class);
        $service->fetchAll(1);
    }

    /**
     * LinksService::fetchByTags()
     * Ensure that the link items match the tag
     *
     * Setup 1 tag with 2 related link records
     * Setup Paginator 1 records per page
     *
     * Expect 2 Links
     * Check Paginator pages, recordsperpage
     */
    public function testFetchByTags_SingleTag(): void
    {
        $expectTotal          = 2;
        $expectRecordsPerPage = 1;
        $this->app->get('config')->set(self::RECORDS_PER_PAGE, $expectRecordsPerPage);
        $service = $this->app->get(LinksService::class);
        LinksTagsModelFactory::new()
            ->has(LinksModelFactory::new()->count(2), 'links')
            ->state(['name' => 'tagtest'])
            ->count(1)
            ->create();

        $results = $service->fetchByTags('tagtest', $expectRecordsPerPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertEquals($expectRecordsPerPage, $results->getCollection()->count());
        $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
    }

    /**
     * LinksService::fetchByTags()
     *
     * Expect - See Tests array below
     * Check Paginator pages, recordsperpage
     */
    public function testFetchByTagsPaginated_MultipleTags(): void
    {
        $expectTotal          = 1;
        $expectRecordsPerPage = 1;
        $this->app->get('config')->set(self::RECORDS_PER_PAGE, $expectRecordsPerPage);
        $service = $this->app->get(LinksService::class);
        LinksModelFactory::new()
            ->has(
                LinksTagsModelFactory::new()
                    ->state(new Sequence(['name' => 'tag1'], ['name' => 'tag2']))->count(2),
                'tags'
            )
            ->count(1)
            ->create();

        $results = $service->fetchByTags('tag1-tag2', $expectRecordsPerPage);

        $this->assertInstanceOf(LengthAwarePaginator::class, $results);
        $this->assertEquals($expectRecordsPerPage, $results->perPage());
        $this->assertEquals($expectTotal, $results->total());
        $this->assertEquals($expectRecordsPerPage, $results->getCollection()->count());
        $this->assertInstanceOf(LinksModel::class, $results->getCollection()[0]);
    }

    /**
     * LinksService::fetchByTags()
     * Fetch Active Links
     * Test paginator going out of range throws exception
     *
     * Expect Exception
     */
    public function testFetchByTags_TestPaginatorOutOfRangeThrowsException(): void
    {
        $service = $this->app->get(LinksService::class);
        LinksTagsModelFactory::new()
            ->has(LinksModelFactory::new()->count(2), 'links')
            ->state(['name' => 'tagtest'])
            ->count(1)
            ->create();

        $this->expectException(PageNotFoundException::class);
        $service->fetchByTags('tagtest', 2);
    }

    /**
     * LinksService::fetchByTags()
     * Check that the cache is called
     */
    public function testFetchByTags_CacheIsCalled(): void
    {
        $paginator = $this->createStub(LengthAwarePaginator::class);
        $mock      = $this->getMockBuilder(CacheManager::class)
            ->disableOriginalConstructor()
            ->addMethods(['remember'])
            ->getMock();
        $mock->expects($this->once())->method('remember')
            ->with()
            ->willReturn($paginator);
        $this->instance('cache', $mock);

        $service = $this->app->get(LinksService::class);
        $service->fetchByTags('tagtest', 1);
    }
}
