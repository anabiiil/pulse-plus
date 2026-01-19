<?php

namespace App\Http\Controllers\Dash;

use App\Action\Image\SendImageToDB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\CreateSliderRequest;
use App\Http\Requests\Admin\Slider\UpdateSliderRequest;
use App\Http\Resources\Dashboard\SliderResource;
use App\Models\Slider;
use App\Support\Enums\File\FileTypeEnum;
use App\Support\Services\Image\ImageService;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    use ApiResponseTrait;

    protected ImageService $imageService;
    protected SendImageToDB $sendImageToDB;

    public mixed $perPage, $sortBy, $orderBy, $search;

    public function __construct()
    {
        $this->imageService = new ImageService();
        $this->sendImageToDB = new SendImageToDB();
    }

    public function index()
    {

        return view('dash.pages.admins.index');
    }

    public function show($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return $this->responseError(msg: 'slider not found');
        }
        return $this->responseData(new SliderResource($slider));
    }


    public function list(Request $request)
    {
        $this->handleData($request);
        $query = Slider::query();
        if ($this->search) {
            $query->where('title', 'like', "%$this->search%")
                ->orWhere('desc', 'like', "%$this->search%");
        }
        $query->orderBy($this->sortBy, $this->orderBy);

        if ($this->perPage == -1) {
            $this->perPage = Slider::count();
        }
        return $this->responseData(SliderResource::collection($query->paginate($this->perPage)));
    }

    public function handleData($request)
    {

        $sortFieldMapping = [
            'id' => 'id',
            'created_at' => 'created_at',
        ];
        $this->sortBy = $sortFieldMapping[$request->get('sortBy', 'id')];
        $this->orderBy = $request->get('sortDesc', 'desc');
        $this->perPage = $request->get('per_page', 50);
        $this->sortBy = $sortFieldMapping[$request->get('sortBy', 'id')];
        $this->search = $request->get('search', '');
    }

    public function create(CreateSliderRequest $request)
    {
        $data = $request->validated();
//        $data['status'] = $data['status'] == 'true' ? 1 : 0;
        $store = Slider::create($data);
        if (isset($data['image'])) {
            $this->sendImageToDB->handle(model: $store, image: $data['image'], path: Slider::IMAGE_PATH, type: FileTypeEnum::BASIC);
        }
        Cache::tags('on_boarding')->flush();

        return $this->responseData([new SliderResource($store)], 201);
    }

    public function update(UpdateSliderRequest $request, $id)
    {
        $data = $request->validated();
        $slider = Slider::find($id);
        if (isset($data['image'])) {
            $this->sendImageToDB->update(model: $slider, image: $data['image'], path: Slider::IMAGE_PATH, type: FileTypeEnum::BASIC);
        }
        $slider->update($data);
        return $this->responseData([new SliderResource($slider)], 200);
    }


    public function destroy($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return $this->responseError(msg: 'slider not found');
        }
        $slider->delete();
        return $this->responseData([], msg: 'slider deleted successfully');
    }
}
