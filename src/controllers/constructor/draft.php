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
				$method = 'getPosts';
				return $this->datas = $model::$method($option);
				break;
			case 'post':
				switch ($action) {
					case 'get':
						$modelPost = ucfirst($page);
						$methodPost = $action . ucfirst($page);
						$this->datas = $modelPost::$methodPost($id);
						// $this->datas->comments = Comment::getComments($id);
						$modelComments = 'Comment';
						$methodComments = 'getComments';
						$this->datas->comments = $modelComments::$methodComments($id);
						return $this->datas;
						break;
					case 'add':
						switch ($option) {
							case 'comment':
								$modelComments = $option;
								$methodComments = $action . ucfirst($option);
								$this->datas = $modelComments::$methodComments($id);
								return $this->datas;
								break;
							default:
								$model = ucfirst($page);
								$method = $action . ucfirst($page);
								return $this->datas = $model::$method();
								break;
						}
						break;
					case 'update':
						switch ($option) {
							case 'get':
								$model = ucfirst($page);
								$method = $option . ucfirst($page);
								return $this->datas = $model::$method($id);
								break;
							case 'comment':
								$modelComments = $option;
								$methodComments = $action . ucfirst($option);
								$this->datas = $modelComments::$methodComments($id);
								return $this->datas;
								break;
							default:
								$model = ucfirst($page);
								$method = $action . ucfirst($page);
								return $this->datas = $model::$method($id);
								break;
						}
						break;
					case 'delete':
						switch ($option) {
							case 'comment':
								$modelComments = $option;
								$methodComments = $action . ucfirst($option);
								$this->datas = $modelComments::$methodComments($id);
								return $this->datas;
								break;
							default:
								$model = ucfirst($page);
								$method = $action . ucfirst($page);
								return $this->datas = $model::$method($id);
								break;
						}
						break;
					case 'validate':
						$model = $option;
						$method = $action . ucfirst($option);
						return $this->datas = $model::$method($id);
						break;
					case 'refuse':
						$modelComments = $option;
						$methodComments = $action . ucfirst($option);
						$this->datas = $modelComments::$methodComments($id);
						return $this->datas;
						break;
				}
				break;
			case 'signup':
				switch ($action) {
					case 'create':
						$model = ucfirst($option);
						$method = $action . ucfirst($option);
						return $this->datas = $model::$method();
						break;
				}
				break;
			case 'login':
				switch ($action) {
					case 'logIn':
						$model = ucfirst($option);
						$method = $action;
						return $this->datas = $model::$method();
						break;
					case 'logOut':
						$model = ucfirst($option);
						$method = $action;
						return $this->datas = $model::$method();
						break;
				}
				break;
			case 'userProfile':
				switch ($action) {
					case 'get':
						$model = ucfirst($option);
						$method = $action . ucfirst($option);
						$this->datas = $model::$method($id);
						UserConnection::UpdateSession($this->datas->id);
						return $this->datas;
						break;
					case 'update':
						$model = ucfirst($option);
						$method = $action . ucfirst($option);
						$this->datas = $model::$method();
						UserConnection::UpdateSession($id);
						return $this->datas;
						break;
					case 'delete':
						$model = ucfirst($option);
						$method = $action . ucfirst($option);
						$this->datas = $model::$method($id);
						return $this->datas;
						break;
				}
				break;
			case 'newsletter':
				switch ($action) {
					case 'subscribe':
						$model = ucfirst($page);
						$method = $action;
						return $this->datas = $model::$method();
						break;
					case 'unsubscribe':
						$model = ucfirst($page);
						$method = $action;
						return $this->datas = $model::$method();
						break;
				}
				break;
			default:
				$model = 'Post';
				$method = 'getPosts';
				return $this->datas = $model::$method(null);
				break;
		}
	}
}
