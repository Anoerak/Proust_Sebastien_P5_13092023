<?php

require_once './templates/view.php';
require_once './src/controllers/constructor/ModelConstructor.php';
require_once './src/model/post.php';
require_once './src/model/comment.php';
require_once './src/model/user.php';
require_once './src/model/userConnection.php';
require_once './src/model/newsletter.php';

class ControllerConstructor extends ModelConstructorController
{
	private $view;
	private $datas;
	private $title = 'IamSeb - ';
	private $templatePath;
	private $actions;

	public function __construct()
	{
		// We store the actions in an array
		$this->actions = [
			'post' => [
				'get' => function ($option) {
					return ['title' => ucfirst($option) . ' a post', 'template' => 'post/post' . ucfirst($option)];
				},
				'add' => [
					'comment' => function () {
						return ['title' => 'Add a comment', 'template' => 'post/post'];
					},
					'_' => function () {
						return ['title' => 'Add a post', 'template' => 'post/postAdd'];
					}
				],
				'update' => function () {
					return ['title' => 'Update a post', 'template' => 'post/postUpdate'];
				}
			],
		];
	}

	public function buildControllerMethod($page, $action = null, $option = null, $id = null)
	{
		// We check if the action is in the array
		$result = null;
		if (isset($this->actions[$page])) {
			if (isset($this->actions[$page][$action])) {
				if (is_callable($this->actions[$page][$action])) {
					// If the action is a function, call it with the option
					$result = ($this->actions[$page][$action])($option);
				} else if (isset($this->actions[$page][$action][$option]) && is_callable($this->actions[$page][$action][$option])) {
					// If the option is a function, call it
					$result = ($this->actions[$page][$action][$option])();
				} else if (isset($this->actions[$page][$action]['_']) && is_callable($this->actions[$page][$action]['_'])) {
					// If there's a default function for this action, call it
					$result = ($this->actions[$page][$action]['_'])();
				}
			}
		}

		// If the action is not in the array, we check if the page is in the array
		if (!isset($result)) {
			// Default case
			$result = ['title' => ucfirst($page), 'template' => $page . '/' . $page];
		}

		$this->title .= $result['title'];
		$this->templatePath = $result['template'];

		// We call the parent method to get the datas
		if (empty($this->datas)) {
			$this->datas = parent::buildModelMethod($page, $action, $option, $id);
		}
		$this->view = new View($this->templatePath, $this->title);
		$this->view->render(array('title' => $this->title, 'page' => $page, 'datas' => $this->datas, 'filter' => $option));
	}
}
