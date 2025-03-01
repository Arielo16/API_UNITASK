<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Users\UseCases\RegisterUser;
use App\Core\Users\UseCases\LoginUser;
use App\Core\Users\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\UserRepository;
use App\Core\Buildings\Repositories\BuildingRepositoryInterface;
use App\Infrastructure\Persistence\BuildingRepository;
use App\Core\Buildings\UseCases\GetAllBuildings;
use App\Core\Buildings\UseCases\GetBuildingById;
use App\Core\Reports\Repositories\ReportRepositoryInterface;
use App\Infrastructure\Persistence\ReportRepository;
use App\Core\Reports\UseCases\GetAllReports;
use App\Core\Reports\UseCases\GetReportsByPriority;
use App\Core\Reports\UseCases\GetReportsByStatus;
use App\Core\Reports\UseCases\CreateReport;
use App\Core\Reports\UseCases\GetReportsByBuildingId;
use App\Core\Reports\UseCases\GetReportsOrderedByDate;
use App\Core\Reports\UseCases\GetReportByFolio;
use App\Core\Reports\UseCases\UpdateReport;
use App\Core\Rooms\Repositories\RoomRepositoryInterface;
use App\Infrastructure\Persistence\RoomRepository;
use App\Core\Rooms\UseCases\GetRoomsByBuildingId;
use App\Core\Categories\Repositories\CategoryRepositoryInterface;
use App\Infrastructure\Persistence\CategoryRepository;
use App\Core\Categories\UseCases\GetAllCategories;
use App\Core\Goods\Repositories\GoodRepositoryInterface;
use App\Infrastructure\Persistence\GoodRepository;
use App\Core\Goods\UseCases\GetGoodsByCategoryId;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(BuildingRepositoryInterface::class, BuildingRepository::class);
        $this->app->singleton(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->singleton(RoomRepositoryInterface::class, RoomRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(GoodRepositoryInterface::class, GoodRepository::class);

        $this->app->singleton(RegisterUser::class, function ($app) {
            return new RegisterUser($app->make(UserRepositoryInterface::class));
        });

        $this->app->singleton(LoginUser::class, function ($app) {
            return new LoginUser($app->make(UserRepositoryInterface::class));
        });

        $this->app->singleton(GetAllBuildings::class, function ($app) {
            return new GetAllBuildings($app->make(BuildingRepositoryInterface::class));
        });

        $this->app->singleton(GetBuildingById::class, function ($app) {
            return new GetBuildingById($app->make(BuildingRepositoryInterface::class));
        });

        $this->app->singleton(GetAllReports::class, function ($app) {
            return new GetAllReports($app->make(ReportRepositoryInterface::class));
        });

        $this->app->singleton(GetReportsByPriority::class, function ($app) {
            return new GetReportsByPriority($app->make(ReportRepositoryInterface::class));
        });

        $this->app->singleton(GetReportsByStatus::class, function ($app) {
            return new GetReportsByStatus($app->make(ReportRepositoryInterface::class));
        });

        $this->app->singleton(CreateReport::class, function ($app) {
            return new CreateReport($app->make(ReportRepositoryInterface::class));
        });

        $this->app->singleton(GetReportsByBuildingId::class, function ($app) {
            return new GetReportsByBuildingId($app->make(ReportRepositoryInterface::class));
        });

        $this->app->singleton(GetReportsOrderedByDate::class, function ($app) {
            return new GetReportsOrderedByDate($app->make(ReportRepositoryInterface::class));
        });

        $this->app->singleton(GetReportByFolio::class, function ($app) {
            return new GetReportByFolio($app->make(ReportRepositoryInterface::class));
        });

        $this->app->singleton(UpdateReport::class, function ($app) {
            return new UpdateReport($app->make(ReportRepositoryInterface::class));
        });

        $this->app->singleton(GetRoomsByBuildingId::class, function ($app) {
            return new GetRoomsByBuildingId($app->make(RoomRepositoryInterface::class));
        });

        $this->app->singleton(GetAllCategories::class, function ($app) {
            return new GetAllCategories($app->make(CategoryRepositoryInterface::class));
        });

        $this->app->singleton(GetGoodsByCategoryId::class, function ($app) {
            return new GetGoodsByCategoryId($app->make(GoodRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
