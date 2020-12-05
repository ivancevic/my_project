<?php

namespace App\Utils;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Utils\AbstractClasses\CategoryTreeAbstract;
/**
 * Description of CategoryTreeFrontPage
 *
 * @author marko
 */
class CategoryTreeFrontPage extends CategoryTreeAbstract  {
    
    
    public $html_1 = '<ul>';
    public $html_2 = '<li>';
    public $html_3 = '<a href="';
    public $html_4 = '">';
    public $html_5 = '</a>';
    public $html_6 = '</li>';
    public $html_7 = '</ul>';
    
    public function getCategoryList(array $categories_array) {
        
       
        $this->categorilist .= $this->html_1;
        
        foreach ($categories_array as $value) {
            $catName = $value['name'];
            $url = $this->urlgenerator->generate('video_list', ['categoryname' => $catName, 'id'=> $value['id']]);
            $this->categorilist .= $this->html_2 . $this->html_3 . $url . $this->html_4 . $catName . $this->html_5;
            
            if (!empty($value['childern'])) {
                $this->getCategoryList($value['childern']);
            }
            
            $this->categorilist .= $this->html_6;
        }
        
        $this->categorilist .= $this->html_7;
            
        return $this->categorilist;
    }
    
    public function getMainParent(int $id): array {
        $key = array_search($id, array_column($this->categoriesArrayFromDb[$key], 'id'));
        
        if ($this->categoriesArrayFromDb[$key]['parent_id'] != null) {
            return $this->getMainParent($this->categoriesArrayFromDb[$key]['parent_id']);
        } else {
            return [
                'id' => $this->categoriesArrayFromDb[$key]['id'],
                'name' => $this->categoriesArrayFromDb[$key]['name']
            ];
        }
    }
}
