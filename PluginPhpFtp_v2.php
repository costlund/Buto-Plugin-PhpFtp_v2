<?php
class PluginPhpFtp_v2{
  private $settings = null;
  private $data = null;
  public function widget_test($data){
    $data = new PluginWfArray($data);
    $this->settings = new PluginWfArray($data->get('data'));
    $this->list($this->settings->get('dir'));
    wfHelp::yml_dump($this->settings);
    wfGlobals::setMicrotimeEnd();
    wfHelp::yml_dump(wfGlobals::getMicrotimeTime());
    wfHelp::yml_dump(sizeof($this->data));
    wfHelp::yml_dump($this->data);
  }
  public function list($dir){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "ftp://".$this->settings->get('server'));
    curl_setopt($curl, CURLOPT_USERPWD, $this->settings->get('user').':'.$this->settings->get('password'));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1) ;
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'CWD '.$dir);
    curl_exec($curl);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'MLSD');
    $ftp_result=curl_exec($curl);
    curl_close($curl);
    wfPlugin::includeonce('string/array');
    $sa = new PluginStringArray();
    foreach($sa->from_br($ftp_result) as $v){
      $i = new PluginWfArray($v);
      if($i->get()){
        $data2 = array();
        foreach($sa->from_char($v, ';') as $v2){
          $temp = $sa->from_char($v2, '=');
          if(isset($temp[1])){
            $data2[$temp[0]] = $temp[1];
          }else{
            $data2['name'] = trim($temp[0]);
          }
        }
        $data2['dir'] = $dir.'/'.$data2['name'];
        if($data2['type']=='file' || $data2['type']=='dir'){
          if($data2['type']=='dir'){
            $this->list($data2['dir']);
          }
          if($data2['type']=='file'){
            $this->data[] = $data2;
          }
        }
      }
    }
    return null;
  }
}