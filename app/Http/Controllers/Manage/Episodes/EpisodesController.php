<?php

namespace App\Http\Controllers\Manage\Episodes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Episodes\EpisodesRequest;
use App\Interfaces\Faqs\FaqsInterface;
use App\Models\Faq;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    private FaqsInterface $repository;
    public function __construct(FaqsInterface $faqs)
    {
        $this->repository = $faqs;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function store(EpisodesRequest $request)
    {
        return $this->repository->store($request);
    }
    public function update(Faq $faq, EpisodesRequest $request)
    {
        return $this->repository->update($request,$faq);
    }

    public function delete(Faq $faq)
    {
        return $this->repository->delete($faq);
    }
}
