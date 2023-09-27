<?php

abstract class ModelConstructorController
{
	private $datas;

	// We define a generic function to build a method based on arguments
	protected function buildModelMethod($page, $action = null, $option = null, $id = null)
	{
		switch ($page) {
			case 'blog':
				$model = 'Post';
				$method = 'getAll';
				return $this->datas = $model::$method($option);
				break;
			case 'post':
				switch ($action) {
					case 'getOne':
						$modelPost = ucfirst((string)$page ?? '');
						$methodPost = $action;
						$this->datas = $modelPost::$methodPost($id);
						$modelComments = 'Comment';
						$methodComments = 'getAll';
						$this->datas->comments = $modelComments::$methodComments($id);
						return $this->datas;
						break;
					case 'create':
						switch ($option) {
							case 'comment':
								$modelComments = ucfirst((string)$option ?? '');
								$methodComments = $action;
								$this->datas = $modelComments::$methodComments($id);
								return $this->datas;
								break;
							default:
								$model = ucfirst((string)$page ?? '');
								$method = $action;
								return $this->datas = $model::$method();
								break;
						}
						break;
					case 'update':
						switch ($option) {
							case 'getOne':
								$model = ucfirst((string)$page ?? '');
								$method = $option . ucfirst((string)$page ?? '');
								return $this->datas = $model::$method($id);
								break;
							case 'comment':
								$modelComments = $option;
								$methodComments = $action;
								$this->datas = $modelComments::$methodComments($id);
								return $this->datas;
								break;
							default:
								$model = ucfirst((string)$page);
								$method = $action;
								return $this->datas = $model::$method($id);
								break;
						}
						break;
					case 'delete':
						switch ($option) {
							case 'comment':
								$modelComments = $option;
								$methodComments = $action;
								$this->datas = $modelComments::$methodComments($id);
								return $this->datas;
								break;
							default:
								$model = ucfirst((string)$page ?? '');
								$method = $action;
								return $this->datas = $model::$method($id);
								break;
						}
						break;
					case 'publish':
						$model = $option;
						$method = $action;
						return $this->datas = $model::$method($id);
						break;
					case 'unpublish':
						$modelComments = $option;
						$methodComments = $action;
						$this->datas = $modelComments::$methodComments($id);
						return $this->datas;
						break;
				}
				break;
			case 'signup':
				switch ($action) {
					case 'create':
						$model = ucfirst((string)$option ?? '');
						$method = $action;
						return $this->datas = $model::$method();
						break;
				}
				break;
			case 'login':
				switch ($action) {
					case 'logIn':
						$model = ucfirst((string)$option ?? '');
						$method = $action;
						return $this->datas = $model::$method();
						break;
					case 'logOut':
						$model = ucfirst((string)$option ?? '');
						$method = $action;
						return $this->datas = $model::$method();
						break;
				}
				break;
			case 'userProfile':
				switch ($action) {
					case 'getOne':
						$model = ucfirst((string)$option ?? '');
						$method = $action;
						$this->datas = $model::$method($id);
						UserConnection::updateSession($this->datas->id);
						return $this->datas;
						break;
					case 'update':
						$model = ucfirst((string)$option ?? '');
						$method = $action;
						$this->datas = $model::$method();
						UserConnection::updateSession($id);
						return $this->datas;
						break;
					case 'delete':
						$model = ucfirst((string)$option ?? '');
						$method = $action;
						$this->datas = $model::$method($id);
						return $this->datas;
						break;
				}
				break;
			case 'newsletter':
				switch ($action) {
					case 'subscribe':
						$model = ucfirst((string)$page ?? '');
						$method = $action;
						return $this->datas = $model::$method();
						break;
					case 'unsubscribe':
						$model = ucfirst((string)$page ?? '');
						$method = $action;
						return $this->datas = $model::$method();
						break;
				}
				break;
			default:
				$model = 'Post';
				$method = 'getAll';
				return $this->datas = $model::$method($option);
				break;
		}
	}
}
