<template>
    <div class="container-fluid">
        <h3 class="mt-5">Vimigo Technical Assessment</h3>
        <div class="card mt-5">
            <div class="card-header">ANNOUNCEMENTS</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Type</th>
                        <th width="20%">Description</th>
                        <th width="10%">Image</th>
                        <th width="10%">Attachment</th>
                        <th width="10%">Action</th>
                    </tr>
                    <tr v-for="row in announcements" :key="row.id">
                        <td>{{ row.id }}</td>
                        <td>{{ row.type }}</td>
                        <td>{{ row.desc }}</td>
                        <td>
                        <img :src="'http://127.0.0.1:8000/asset/uploads/announcement_img/'+ row.image" class="img-fluid" style="max-height:100px; min-height: 50px; max-width: 100px; min-width: 50px;">
                        </td>
                        <td>
                            <a v-if="row.attachment != ''" :href="'http://127.0.0.1:8000/asset/uploads/announcement_attachment/'+ row.attachment" target="blank" style="border:0.1px solid black;padding:2px 5px;color:black;text-decoration:none;">OPEN</a>
                            <span v-else>-</span>
                        </td>
                        <td>
                            <a :href="'http://127.0.0.1:8000/Announcement/edit/' + row.encrypted_id" style="border:0.1px solid black;padding:2px 5px;color:black;text-decoration:none;">EDIT</a>
                            <a v-on:click="delete_announcement(row.encrypted_id)" style="border:0.1px solid black;padding:2px 5px;color:black;text-decoration:none;margin-left: 5px;">DELETE</a>
                        </td>
                    </tr>
                </table>
               
            </div>
        </div>
        <div class="mt-3">
            <a class="btn btn-default" href="http://127.0.0.1:8000/Announcement/add" style="float:right;background-color:#74c4d8;color:white;font-weight: bold;">Create Announcement</a>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { error_response, success_response, warning_response } from '../../../../vue-laravel/resources/js/sweetalert';
var header = { headers: { 'Content-Type': 'multipart/form-data' } };

    export default {
        data() {
            return {
                announcements: null,
            }
        },
        mounted() {
            fetch("http://127.0.0.1:8000/api/Announcement/get_all_announcements")
            .then(async (response) => {
                var data = await response.json();
                this.announcements = data.data.data;
                console.log(data.data.data)
            })
            .catch((err) =>{
                throw err;
            })
        },
        methods: {
            delete_announcement(id){
                if(confirm("Are you sure you want to delete this announcement?")){
                    var formdata = new FormData();
                    formdata.append("announcement_id", id);

                    axios.post("http://127.0.0.1:8000/api/Announcement/delete", formdata, header)
                    .then((response) => {
                        if(response.data.status == "Success"){
                            success_response("Successfully deleted!", true, "Announcement");
                        }else{
                            warning_response(response.data.message);
                        }
                    })
                    .catch((err) => {
                        throw err;
                    })
                }
            }
        }
    }
</script>
