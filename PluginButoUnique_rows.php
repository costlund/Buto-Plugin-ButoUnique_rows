<?php
class PluginButoUnique_rows{
  function __construct() {
    wfPlugin::includeonce('wf/yml');
    wfPlugin::enable('theme/include');
    wfRequest::$trim = false;
  }
  public function page_form(){
    $element = new PluginWfYml(__DIR__.'/element/form.yml');
    wfDocument::renderElement($element->get());
  }
  public function page_parse(){
    $rows = preg_split("/\r\n/", wfRequest::get('text'));
    $unique = array();
    foreach ($rows as $key => $row) {
      if(!isset($unique[$row])){
        $unique[$row] = array('count' => 1, 'value' => $row);
      }else{
        $unique[$row]['count'] = $unique[$row]['count']+1;
      }
    }
    $str = '';
    foreach ($unique as $key => $value) {
      $str .= $value['count']."\t".$value['value']."\n";
    }
    $element = new PluginWfYml(__DIR__.'/element/parse.yml');
    $element->setByTag(array('str' => $str));
    wfDocument::renderElement($element->get());
  }
}
