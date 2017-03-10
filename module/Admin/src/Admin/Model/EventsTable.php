<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class EventsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {

        $resultSet = $this->tableGateway->select(function (Select $select) {
                $select->join('tbl_country','tbl_upcoming_events.country_id = tbl_country.id',array("country_name"),Select::JOIN_INNER);
                $select->join('tbl_city','tbl_upcoming_events.city_id = tbl_city.id',array("city_name"),Select::JOIN_INNER);
        });

        return $resultSet;
    }

    public function getEvents($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

    public function getEventsjoin($id) {
        $resultSet = $this->tableGateway->select(function (Select $select) use($id){
            $select->where(array('tbl_upcoming_events.id'=>$id));
            $select->join('tbl_country','tbl_upcoming_events.country_id = tbl_country.id',array('country_name'));
            $select->join('tbl_state','tbl_upcoming_events.state_id = tbl_state.id',array('state_name'));
            $select->join('tbl_city','tbl_upcoming_events.city_id = tbl_city.id',array('city_name'));
            $select->join('tbl_admin_login','tbl_upcoming_events.created_by = tbl_admin_login.id',array('username'));
        })->current();

        return $resultSet;
    }

    public function deleteEvents($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveEvents($eventsEntity)
    {
    	$eventsEntity->created_date = (empty($eventsEntity->created_date))? date('Y-m-d h:i:s'):$eventsEntity->created_date;
                $eventsEntity->modified_date = (empty($eventsEntity->modified_date))? date('Y-m-d h:i:s'):$eventsEntity->modified_date;
                $eventsEntity->event_date = date("Y-m-d h:i:s",strtotime($eventsEntity->event_date));
                $eventsEntity->end_date = date("Y-m-d h:i:s",strtotime($eventsEntity->end_date));
                $eventsEntity->start_time = date("h:i:s",strtotime($eventsEntity->start_time));
                $eventsEntity->end_time = date("h:i:s",strtotime($eventsEntity->end_time));
                

                $photos = array("image","organiser_photo","sponser_photo");
                 if($eventsEntity->id==0){
                foreach ($photos as $key => $value) {
                    $dat = (object)$eventsEntity->$value;
                    
                    if($dat->name!=""){

                        // echo $dat->type;
                        
                        $images[]= $this->uploadFiles($dat,$value);
                    }
                    else $images[]= "/img/default_user.png";


                }
            }
            else {

                foreach ($photos as $key => $value) {
                    $dat = (object)$eventsEntity->$value;
                    
                    if($dat->name!=""){

                        // echo $dat->type;
                        
                        $images[]= $this->uploadFiles($dat,$value);
                    }
                    else $images[]= "/img/default_user.png";


                }

            }
                // $val = "image";
                // ;
                // echo "<pre> Development mode ahead";die;
                print_r($images);
                  print_r($eventsEntity);
                die;
    	   // 
             
                $status = ($eventsEntity->IsActive==0)? 0:1;

                    $data = array(
                'event_name' => $eventsEntity->event_name,
                'event_date' => $eventsEntity->event_date,
                'event_desc' => $eventsEntity->event_desc,
                'IsActive' => $status,
                'country_id' => $eventsEntity->country_id,
                'state_id' => $eventsEntity->state_id,
                'city_id' => $eventsEntity->city_id,
                'venue' => $eventsEntity->venue,
                'image' => $images[0],
                'organiser_photo' => $images[1],
                'sponser_photo' => $images[2],
                'end_date' => $eventsEntity->end_date,
                'start_time' => $eventsEntity->start_time,
                'end_time' => $eventsEntity->end_time,
                'created_date' => $eventsEntity->created_date,
                'modified_date' => $eventsEntity->modified_date,
                'event_cost' => $eventsEntity->event_cost,
                'event_members' => $eventsEntity->event_members,
                'sponser_name' => $eventsEntity->sponser_name,
                'event_organiser' => $eventsEntity->event_organiser,
                'sponser_contact' => $eventsEntity->sponser_contact,
                'organiser_contact' => $eventsEntity->organiser_contact,
                'created_by' => "1"
                );
                    // print_r($data);die;
                       if($eventsEntity->id==0){
                        $resultSet = $this->tableGateway->insert($data);
                        }
                    else {
                                if ($this->getEvents($eventsEntity->id)) {

                                    $this->tableGateway->update($data, array('id' => $eventsEntity->id));

                                    } else {
                                    throw new \Exception('Users id does not exist');
                                }
                        }


    }

    public function uploadFiles($file,$field)
    {
        // echo "sdsd";die;
        $filename = $file->name;
                $fileTmpName = $file->tmp_name;
                $filetype = $file->type;
                $filesize = $file->size;
                $filext = pathinfo($filename,PATHINFO_EXTENSION);
                $innerpath = '/img/EventsImages/'.time().$filename;
                $filepath = ROOT_PATH.$innerpath;

                if(in_array($filext, array('jpg','png','gif','JPEG','JPG'))){

                        if($filesize<500000)
                    {
                         
                       if(move_uploaded_file($fileTmpName, $filepath))
                            $error = "";
                        else {
                            $error = "couldnt upload files".$filepath;
                            $innerpath="/img/default_user.png";
                        }
                    }
                    else  {
                        $error = "file size must not be smaller than 5 MB";
                        $innerpath="/img/default_user.png";
                    }

                }
                else  {
                    $error = "only jpg,png or gif files are allowed";
                    $innerpath="/img/default_user.png";
                }

                return $innerpath;

    }

    public function updatestatus($data)
    {
        $changedata = array('IsActive'=>$data->IsActive);
        // return "dfgdgdfgd";
        $status = $this->tableGateway->update($changedata,array('id'=>$data->id));
            
        if($status){
            $respArr = array('status'=>"Updated SuccessFully");
        }   
            
        else $respArr = array('status'=>"Couldn't update");

        return $respArr;

    }


}
