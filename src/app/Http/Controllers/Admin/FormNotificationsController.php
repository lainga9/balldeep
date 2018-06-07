<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\FormNotification;
use Lainga9\BallDeep\app\Form;
use Lainga9\BallDeep\app\Http\Requests\StoreFormNotificationRequest;

class FormNotificationsController extends Controller {

	/**
	 * Instance of FormNotification model
	 * 
	 * @var FormNotification
	 */
	protected $notification;

	/**
	 * Constructor method
	 * 
	 * @param FormNotification $notification
	 */
	public function __construct(FormNotification $notification)
	{
		$this->notification = $notification;
	}
	
	/**
	 * Show form for creating a notification
	 * 
	 * @param  Form  $form
	 * @return Response
	 */
	public function create(Form $form)
	{
		return view('balldeep::admin.forms.notifications.create', compact('form'));
	}

	/**
	 * Store a notification
	 * 
	 * @param  Form                         $form
	 * @param  StoreFormNotificationRequest $request
	 * @return Response
	 */
	public function store(Form $form, StoreFormNotificationRequest $request)
	{
		$form->notifications()->create($request->all());

		return redirect()->route('balldeep.admin.forms.notifications.index', $form)->with('success', 'Notification successfully stored!');
	}

	/**
	 * Show form for editing a notification
	 * 
	 * @param  FormNotification $notification
	 * @return Response
	 */
	public function edit(FormNotification $notification)
	{
		return view('balldeep::admin.forms.notifications.edit', compact('notification'));
	}

	/**
	 * Update a notification
	 * 
	 * @param  Notification                 $notification
	 * @param  StoreFormNotificationRequest $request
	 * @return Response
	 */
	public function update(FormNotification $notification, StoreFormNotificationRequest $request)
	{
		$notification->update($request->all());

		return redirect()->back()->with('success', 'Notification updated!');
	}
}