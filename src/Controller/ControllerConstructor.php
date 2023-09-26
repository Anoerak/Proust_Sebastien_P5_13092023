<?php

require_once './templates/view.php';
require_once './src/Controller/ModelConstructor.php';
require_once './src/Entity/post.php';
require_once './src/Entity/comment.php';
require_once './src/Entity/user.php';
require_once './src/Entity/userConnection.php';
require_once './src/Entity/newsletter.php';


class ControllerConstructor extends ModelConstructorController
{
	private $view;
	private $datas;
	private $title = 'My Awesome Blog !! - ';
	private $templatePath;

	private function setTitleAndTemplatePath($titleAppendix, $templatePathAppendix)
	{
		$this->title .= $titleAppendix;
		$this->templatePath = $templatePathAppendix;
	}

	private function setDefaultTitleAndTemplatePath($page)
	{
		$this->setTitleAndTemplatePath(ucfirst($page), $page . '/' . $page);
	}

	private function handlePostAction($action, $option, $page)
	{
		switch ($action) {
			case 'get':
				$this->setTitleAndTemplatePath(ucfirst($option) . ' a ' . $page, $page . '/' . $page . ucfirst($option));
				break;
			case 'add':
				$titleAppendix = 'a ' . ($option === 'comment' ? '' : $page);
				$templatePathAppendix = $page . '/' . ($option === 'comment' ? $page : $page . 'Add');
				$this->setTitleAndTemplatePath(ucfirst($action) . $titleAppendix, $templatePathAppendix);
				break;
			case 'new':
				$this->setTitleAndTemplatePath(ucfirst($action) . ' a ' . $page, $page . '/' . $page . 'Add');
				break;
			case 'update':
				$titleAppendix = ' a ' . $page;
				$templatePathAppendix = $page . '/' . $page . ucfirst($action);
				if ($option === 'comment') {
					$titleAppendix = 'a ' . $option;
					$templatePathAppendix = $page . '/' . $page;
				}
				$this->setTitleAndTemplatePath(ucfirst($action) . $titleAppendix, $templatePathAppendix);
				break;
			case 'delete':
				$titleAppendix = ' a ' . $page;
				$templatePathAppendix = $page . '/' . $page;
				if ($option === 'comment') {
					$titleAppendix = 'a ' . $option;
					$templatePathAppendix = $page . '/' . $page;
				}
				$this->setTitleAndTemplatePath(ucfirst($action) . $titleAppendix, $templatePathAppendix);
				break;
		}
	}

	public function buildControllerMethod($page, $action = null, $option = null, $id = null)
	{
		switch ($page) {
			case 'post':
				$this->handlePostAction($action, $option, $page);
				break;
			case 'userProfile':
				session_start();
				if (!isset($_SESSION['logged_user'])) {
					try {
						header('Location: index.php?page=login');
					} catch (Exception $e) {
						echo 'Exception reçue : ',  $e->getMessage(), "\n";
					}
				}
				switch ($action) {
					case 'get':
					case 'update':
					case 'delete':
						$this->setDefaultTitleAndTemplatePath($page);
						break;
				}
				break;
				// Handle other cases...
			default:
				$this->setDefaultTitleAndTemplatePath($page);
				break;
		}

		if (empty($this->datas)) {
			$this->datas = parent::buildModelMethod($page, $action, $option, $id);
		}

		$this->view = new View($this->templatePath, $this->title);
		$this->view->render(['title' => $this->title, 'page' => $page, 'datas' => $this->datas, 'filter' => $option]);
	}
}
