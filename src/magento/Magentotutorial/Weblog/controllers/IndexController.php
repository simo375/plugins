<?php
class Magentotutorial_Weblog_IndexController extends Mage_Core_Controller_Front_Action {
	public function indexAction() {
		$this->loadLayout();
        $this->renderLayout();
	}


    public function testModelAction() {
    	$params = $this->getRequest()->getParams();
	    $blogpost = Mage::getModel('weblog/blogpost');
	    echo("Loading the blogpost with an ID of ".$params['id']);
	    $blogpost->load($params['id']);
	    $data = $blogpost->getData();
	    var_dump($data);
    }

    public function showAllBlogPostsAction() {
	    $posts = Mage::getModel('weblog/blogpost')->getCollection();
	    foreach($posts as $blogpost){
	        echo '<h3>'.$blogpost->getTitle().'</h3>';
	        echo nl2br($blogpost->getPost());
	    }
	}
}
?>