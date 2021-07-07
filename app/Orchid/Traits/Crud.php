<?php

namespace App\Orchid\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

trait Crud
{
    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $model = new $this->screenData['model']();

        $model->fill($request->all())->save();

        Toast::info("Операция добавления успешно завершена");

        return redirect()->route($this->screenData['routeRedirect']);
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $model = new $this->screenData['model']();

        $updateData = $request->get($this->screenData['key']);

        $model->where('id', $updateData['id'])
              ->update($request->get($this->screenData['key']));

        Toast::info('Операция обновления успешно завершена');

        return redirect()->route($this->screenData['routeRedirect']);
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $model = new $this->screenData['model']();

        $model->destroy($request->get('id'));

        Toast::info('Операция удаления успешно завершена');

        return redirect()->route($this->screenData['routeRedirect']);
    }
}
