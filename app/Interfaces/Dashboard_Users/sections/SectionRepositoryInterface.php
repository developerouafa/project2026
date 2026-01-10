<?php
namespace App\Interfaces\Dashboard_Users\sections;


interface SectionRepositoryInterface
{

    //* get All Sections
    public function index();

    //* Export Excel
    public function export();

    //* get All Softdelete
    public function softdelete();

    //* store Sections
    public function store($request);

    //* Update Sections
    public function update($request);

    //* destroy Sections
    public function destroy($request);

    //* show Section Products
    public function showsection($id);

    //* Hide Section
    public function editstatusdéactive($id);

    //* show Section
    public function editstatusactive($id);

    //* delete All Section
    public function deleteall();

    //* delete All Section softdelete
    public function deleteallsoftdelete();

    //* Restore
    public function restore($id);

    //* Restore  All Sections
    public function restoreallsections();

    //* Restore  All Select Section
    public function restoreallselectsections($request);
}
