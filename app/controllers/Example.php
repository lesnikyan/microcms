<?php

namespace Controller;

use Mvc\View;
use Mvc\Model;
use Db\Entity\Item;
use Db\Model\Items as ItModel;
use \r;
use \cookie;

/**
 * Description of Example
 *
 * @author Less
 */
class Example extends \Mvc\Controller {
    
    public function index() {
        // view of last item
        $model = new ItModel();
        $item = $model->find(Model::LAST);
        $this->viewItem($item);
    }
    
    public function view($id){
        // show one item data
        $id = intval($id);
        $model = new ItModel();
        $item = $model->find($id);
        $this->viewItem($item);
    }
    
    private function viewItem(Item $item){
        if(! $item || empty($item)){
            $content =  new View(null, "Incorrect id of item");
        } else {
            $content =  new View('example/view', ['info' => $item->getData()]);
        }
        $this->toMain($content);
    }
    
    public function items(){
        // show list of items
        $model = new ItModel();
        $items = $model->findList();
        $content = new \Mvc\View('example/list', ['items' => $items, 'fields' => Item::getFields()]);
        $this->toMain($content);
    }
    
    public function create(){
        // create new item
        $item = new Item();
        $this->editForm($item);
    }
    
    public function edit($id = null){
        // show form
        $id = intval($id);        
        $model = new ItModel();
        $item = $model->find($id);
        $this->editForm($item);
    }
    
    private function editForm(Item $item){
        $types = [
            'description' => 'text',
            'type' => 'enum',
            '_enums' => [
                'type' => Item::$typeList
            ]
        ];
        $content = new View('example/form', [
            'data' => $item->getData(),
            'types' => $types
                ]);
        $this->toMain($content);
    }
    
    public function save(){
        // save form data
        $fields = Item::getFields();
        $data = r::fromPost($fields);
        $data['id'] = intval($data['id']);
        $item = new Item($data);
        $model = new ItModel();
        $model->save($item);
        r::redirect('/example/view/' . $item->id);
    }
    
    public function del($id){
        $id = intval($id);  
        $model = new ItModel();
        $item = $model->find($id);
        if(! $item){
            return (new View(null, 'Incorect ID. Back to previous page.'))->render(1);
        }
        cookie::set('del_item_confirm', 'confirm', time() + 30);
        cookie::set('del_item_id', $id, time() + 30);
        (new View('example/delpage', ['item' => $item]))->render(true);
    }
    
    public function delconfirm(){
        if(cookie::get('del_item_confirm') !== 'confirm'){
            // no valid cookie
            return (new View(null, 'incorrect request'))->render(1);
        }
        $id = intval(\cookie::get('del_item_id'));
        $model = new ItModel();
        $model->del($id);
        cookie::del('del_item_confirm');
        cookie::del('del_item_id');
        r::redirect('/example/items');
    }
    
    private function toMain(View $body){
        (new View('example/main', ['body' => $body->render()]))->render(true);
    }
    
    public function plane(){
        (new View('/example/planecontent', "Just simple plane text"))->render(1);
    }

}
