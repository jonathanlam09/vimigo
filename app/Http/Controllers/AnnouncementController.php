<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(){
        
    }

    public function get_all_announcements(){
        $announcement = Announcement::where("active", 1)->get();
        foreach($announcement as $row){
            $type = AnnouncementType::find($row->type_id);
            $row->type = $type->name;
            $row->encrypted_id = encrypt_decrypt("encrypt", $row->id);
        }
        $data = ["data" => $announcement];
        $json['response_data'] = $data;
        return view("output/success_response", $json);
    }

    public function get_announcement(Request $request){
        $announcement_id = $request->post("announcement_id");
        $announcement_id = encrypt_decrypt("decrypt", $announcement_id);

        if($announcement_id == false){
            $data['message'] = "Error!";
            return view("output/error_response", $data);
        }
       
        $announcement = Announcement::find($announcement_id);
        $data = ["data" => $announcement];
        $json['response_data'] = $data;
        return view("output/success_response", $json);
    }

    public function manage(Request $request){
        $announcement_id = $request->post("announcement_id");
        $announcement_id = isset($announcement_id) ? $announcement_id : 0;
        $desc = $request->post("desc");
        $type_id = $request->post("type_id");

        if($type_id == ""){
            $data['message'] = "Announcement type cannot be empty!";
            return view("output/error_response", $data);
        }
        if($desc == ""){
            $data['message'] = "Announcement description cannot be empty!";
            return view("output/error_response", $data);
        }

        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|mimes:heic,png,jpg,jpeg',
            ]);
     
            $image_file = $request->image->getClientOriginalName();
            $filePath = 'uploads/announcement_img/' . $image_file;
            $path = Storage::disk('asset')->put($filePath, file_get_contents($request->image));
            $path = Storage::disk('asset')->url($path);
        }else{
            $image_file = "";
        }

        if($request->hasFile('attachment')){
            $request->validate([
                'attachment' => 'required|mimes:pdf',
            ]);
     
            $attachment_file = $request->attachment->getClientOriginalName();
            $filePath = 'uploads/announcement_attachment/' . $attachment_file;
            $path = Storage::disk('asset')->put($filePath, file_get_contents($request->attachment));
            $path = Storage::disk('asset')->url($path);
        }else{
            $attachment_file = "";
        }
        if($announcement_id != 0){
            //update
            $announcement = Announcement::find($announcement_id);
            $announcement->desc = $desc;
            $announcement->type_id = $type_id;
            if($image_file != ""){
                $announcement->image = $image_file;
            }
            if($attachment_file != ""){
                $announcement->attachment = $attachment_file;
            }
            if(!$announcement->save()){
                $data['message'] = "Error!";
                return view("output/error_response", $data);
            }
        }else{
            //insert
            $announcement = new Announcement();
            $announcement->desc = $desc;
            $announcement->type_id = $type_id;
            $announcement->image = $image_file;
            $announcement->attachment = $attachment_file;
            if(!$announcement->save()){
                $data['message'] = "Error!";
                return view("output/error_response", $data);
            }
        }
        return view('output/success_response');
    }

    public function get_announcement_types(){
        $type = AnnouncementType::where('active', 1)->get();
        $data = ["data" => $type];
        $json['response_data'] = $data;
        return view('output/success_response', $json);
    }

    public function delete(Request $request){
        $announcement_id = $request->post("announcement_id");
        $announcement_id = encrypt_decrypt("decrypt", $announcement_id);

        if($announcement_id == false){
            $data['message'] = "Error!";
            return view("output/error_response", $data);
        }
        
        $announcement = Announcement::find($announcement_id);
        $announcement->active = 0;
        if(!$announcement->save()){
            $data['message'] = "Error!";
            return view("output/error_response", $data);
        }
        return view("output/success_response");
    }
}
