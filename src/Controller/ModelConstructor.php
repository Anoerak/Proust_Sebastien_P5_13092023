<?php

abstract class ModelConstructorController
{
	private $datas;

	// Define a map for page to model
	private $pageToModel = [
		'blog' => 'Post',
		'post' => 'Post',
		'signup' => 'User',
		'login' => 'User',
		'userProfile' => 'User',
		'newsletter' => 'Newsletter',
	];

	// Define a map for action to method
	private $actionToMethod = [
		'getOne' => 'getOne',
		'create' => 'create',
		'update' => 'update',
		'delete' => 'delete',
		'publish' => 'publish',
		'unpublish' => 'unpublish',
		'logIn' => 'logIn',
		'logOut' => 'logOut',
		'subscribe' => 'subscribe',
		'unsubscribe' => 'unsubscribe',
	];

	protected function buildModelMethod($page, $action = null, $option = null, $id = null)
	{
		$model = $this->getModel($page, $option);
		$method = $this->getMethod($action, $option);

		if ($model && $method) {
			if (($action === 'create' || $action === 'update' || $action === 'delete') && $option === 'comment') {
				$this->datas = Comment::$method($id);
			} else if ($action === 'publish' || $action === 'unpublish') {
				if ($option === 'comment') {
					$this->datas = Comment::$method($id);
				} else {
					$this->datas = $model::$method($id);
				}
			} else if ($action === 'logIn' || $action === 'logOut' && $option === 'userConnection') {
				$this->datas = UserConnection::$method();
			} else if ($page === 'userProfile' && ($action === 'getOne' || $action === 'update' || $action === 'delete') && $option === 'user') {
				$this->datas = User::$method($id);
				UserConnection::updateSession($id);
			} else {
				$this->datas = $model::$method($id);
				if ($page === 'post' && $action === 'getOne') {
					$this->datas->comments = Comment::getAll($id);
				}
			}
			return $this->datas;
		}

		// Default case
		return $this->datas = Post::getAll($option);
	}



	private function getModel($page, $option)
	{
		if (isset($this->pageToModel[$page])) {
			return $this->pageToModel[$page];
		}
		if (isset($this->pageToModel[$option])) {
			return $this->pageToModel[$option];
		}
		return null;
	}

	private function getMethod($action, $option)
	{
		if (isset($this->actionToMethod[$action])) {
			return $this->actionToMethod[$action];
		}
		if (isset($this->actionToMethod[$option])) {
			return $this->actionToMethod[$option];
		}
		return null;
	}
}
