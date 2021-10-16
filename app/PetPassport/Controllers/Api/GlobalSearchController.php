<?php

namespace App\PetPassport\Controllers\Api;

use App\PetPassport\Models\Announcement\Announcement;
use App\PetPassport\Models\Announcement\AnnouncementPet;
use App\PetPassport\Models\Community\Community;
use App\PetPassport\Models\Post;
use App\PetPassport\Models\User\UserProfile;
use App\PetPassport\Search\SearchAggregator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Traits\QueryElasticSearchTrait;

class GlobalSearchController extends Controller
{
    use QueryElasticSearchTrait;

    /**
     * @var Announcement
     */
    private $announcement;

    /**
     * @var array
     */
    private $announcementModel = [Announcement::CLASS];

    /**
     * @var array
     */
    private $networkModel = [Post::CLASS, Community::CLASS, UserProfile::CLASS];

//    /**
//     * GlobalSearchController constructor.
//     * @param Announcement $announcement
//     */
//    function __construct(Announcement $announcement) {
//        $this->announcement = $announcement;
//    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fastSearch(Request $request)
    {
        $sectionId = $request->input('filter')['section_id'] ?? null;
        $cityId = $request->input('filter')['city_id'] ?? null;
        $countryId = $request->input('filter')['country_id'] ?? null;
        $categoryId = $request->input('filter')['category_id'] ?? null;
        switch ($sectionId) {
            case 1:
                $searchModels = $this->announcementModel;
                break;
            case 2:
                $searchModels = $this->networkModel;
                break;
            default:
//                $searchModels = [...$this->networkModel, ...$this->announcementModel];
        }
        $searchAggregator = new SearchAggregator($searchModels);
        $result = $searchAggregator->search($request->input('searchText') ?? '', $categoryId, $countryId, $cityId);
        return response()->json($result);
    }
}
