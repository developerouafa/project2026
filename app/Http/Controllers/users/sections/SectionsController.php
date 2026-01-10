<?php

namespace App\Http\Controllers\users\sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Sections\StoreSectionRequest;
use App\Interfaces\Dashboard_Users\sections\SectionRepositoryInterface;
use App\Models\sections;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\Store;

class SectionsController extends Controller
{

    private $Sections;

    public function __construct(SectionRepositoryInterface $Sections)
    {
        $this->Sections = $Sections;
    }

    public function index()
    {
      return  $this->Sections->index();
    }

    public function export()
    {
      return  $this->Sections->export();
    }

    public function softdelete()
    {
      return  $this->Sections->softdelete();
    }

    public function showsection($id)
    {
       return $this->Sections->showsection($id);
    }

    public function store(StoreSectionRequest $request)
    {
        return $this->Sections->store($request);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_'.app()->getLocale() => 'required|unique:sections,name->'.app()->getLocale().','.$request->id,
        ],[
            'name_'.app()->getLocale().'.required' =>__('Dashboard/sections_trans.namerequired'),
            'name_'.app()->getLocale().'.unique' =>__('Dashboard/sections_trans.nameunique'),
        ]);

        return $this->Sections->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->Sections->destroy($request);
    }

    public function editstatusdéactive($id)
    {
        return $this->Sections->editstatusdéactive($id);
    }

    public function editstatusactive($id)
    {
        return $this->Sections->editstatusactive($id);
    }

    public function deleteall()
    {
        return $this->Sections->deleteall();
    }

    public function deleteallsoftdelete()
    {
        return $this->Sections->deleteallsoftdelete();
    }

    public function restore($id)
    {
        return $this->Sections->restore($id);
    }

    public function restoreallsections()
    {
        return $this->Sections->restoreallsections();
    }

    public function restoreallselectsections(Request $request)
    {
        return $this->Sections->restoreallselectsections($request);
    }
}
