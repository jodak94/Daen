<?php

namespace Modules\Analisis\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterAnalisisSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('analisis::analises.title.analises'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('analisis::analises.title.analises'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.analisis.analisis.create');
                    $item->route('admin.analisis.analisis.index');
                    $item->authorize(
                        $this->auth->hasAccess('analisis.analises.index')
                    );
                });
                $item->item(trans('analisis::seccions.title.seccions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.analisis.seccion.create');
                    $item->route('admin.analisis.seccion.index');
                    $item->authorize(
                        $this->auth->hasAccess('analisis.seccions.index')
                    );
                });
                $item->item(trans('analisis::resultados.title.resultados'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.analisis.resultado.create');
                    $item->route('admin.analisis.resultado.index');
                    $item->authorize(
                        $this->auth->hasAccess('analisis.resultados.index')
                    );
                });
                $item->item(trans('analisis::determinacions.title.determinacions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.analisis.determinacion.create');
                    $item->route('admin.analisis.determinacion.index');
                    $item->authorize(
                        $this->auth->hasAccess('analisis.determinacions.index')
                    );
                });
                $item->item(trans('analisis::plantillas.title.plantillas'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.analisis.plantilla.create');
                    $item->route('admin.analisis.plantilla.index');
                    $item->authorize(
                        $this->auth->hasAccess('analisis.plantillas.index')
                    );
                });
// append






            });
        });

        return $menu;
    }
}