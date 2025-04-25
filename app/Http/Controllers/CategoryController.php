<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function get_categories(int $id=0)
    {
        return $this->categoryRepository->findOrAll($id);
    }

    public function create_category(CreateCategoryRequest $request)
    {
        return $this->categoryRepository->create($request->all());
    }

    public function update_category(UpdateCategoryRequest $request, int $id)
    {
        return $this->categoryRepository->update($id, $request->all());
    }

    public function delete_category(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}
