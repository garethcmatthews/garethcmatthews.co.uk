<?php

namespace App\Http\Controllers;

use App\Modules\Contact\ContactService;
use App\Modules\Contact\Requests\ContactRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

use function redirect;

class ContactsController extends BaseController
{
    public function index(Session $session, ViewFactory $view): View
    {
        $message = null;
        if ($session->has('success')) {
            $message = $session->get('success');
            $session->forget('success');
        }

        return $view->make('App::landing-pages.contact', ['message' => $message]);
    }

    public function store(ContactService $service, ContactRequest $request): RedirectResponse
    {
        $service->store($request->all());
        return redirect()->back()->with('success', '<strong>Thankyou</strong> - Your Message has been sent.');
    }
}
