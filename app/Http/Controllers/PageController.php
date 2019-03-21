<?php

namespace App\Http\Controllers;

use App\Place;
use Pvtl\VoyagerPages\Page;
use Pvtl\VoyagerFrontend\Helpers\Layouts;
use Pvtl\VoyagerFrontend\Traits\Breadcrumbs;
use Pvtl\VoyagerFrontend\Helpers\BladeCompiler;
use Illuminate\Http\Request;

class PageController extends \Pvtl\VoyagerPages\Http\Controllers\PageController
{
    use Breadcrumbs;

    protected $viewPath = 'voyager-frontend';

    /**
     * Add the layout to the returned page
     *
     * @param string $slug
     *
     * @return string
     */
    public function getPage($slug = 'home')
    {
        $page = Page::where('slug', '=', $slug)->firstOrFail();
        $places = Place::all();

        $view = view("{$this->viewPath}::modules.pages.default", [
            'page' => $page,
            'places' => $places,
        ]);

        $page = Page::findOrFail((int)$view->page->id);

        $view->layout = $page->layout;
        $view = BladeCompiler::getHtmlFromString($view, [], true);

        return $view;
    }

    /**
     * POST B(R)EAD - Create data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function create(Request $request)
    {
        $view = parent::create($request);

        $view['layouts'] = Layouts::getLayouts('voyager-frontend');

        return $view;
    }

    /**
     * POST B(R)EAD - Read data.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return View
     */
    public function edit(Request $request, $id)
    {
        $view = parent::edit($request, $id);

        $view['layouts'] = Layouts::getLayouts('voyager-frontend');

        return $view;
    }


    /**
     * POST - Change Page Layout
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id - the page id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLayout(Request $request, $id)
    {
        $page = Page::findOrFail((int)$id);
        $page->layout = $request->layout;
        $page->save();

        return redirect()
            ->back()
            ->with([
                'message' => __('voyager::generic.successfully_updated') . " Page Layout",
                'alert-type' => 'success',
            ]);
    }

    public function showBreak(Request $request, $id, $slug = 'home')
    {
        $page = Page::where('slug', '=', $slug)->firstOrFail();
        $place = Place::findOrFail($id);

        $view = view("{$this->viewPath}::modules.pages.showBreak", [
            'page' => $page,
            'place' => $place,
        ]);

        $page = Page::findOrFail((int)$view->page->id);

        $view->layout = $page->layout;
        $view = BladeCompiler::getHtmlFromString($view, [], true);

        return $view;
    }
}