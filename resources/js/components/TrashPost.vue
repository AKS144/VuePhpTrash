<template>
  <div>
      <div id="toolbar">
          <a href="/posts" class="btn btn-primary"><i class="fas fa-list-alt"></i>View All</a>
         <button @click="checkPosts('restore')" class="btn btn-success"><i class="fas fa-trash-restore"></i>Restore Selected</button>
        <button @click="checkPosts('delete')" class="btn btn-danger"><i class="fas fa-time-cicrle"></i>Delete Permanently</button>
      </div>
      <bootstrap-table :data="myPosts" :options="myOptions" :columns="myColumns"/>
  </div>
</template>

<script>
import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.min.js'

export default {
    props: ['posts'],
    components:{
        'bootstrap-table': BootstrapTable
    },
    data(){
        return {
            mySelections:[],
            myPosts:[],
            myOptions:{
                search:true,
                pagination: true,
                showColumns: true,
                showPrint: true,
                showExport: true,
                fileControl: true,
                toolbar: '#toolbar',
                clickToSelect: true,
                idField: 'id',
                selectItemName:'id',
            },
            myColumns:[ 
                { field:'state', checkbox: true },
                { field:'id', title:'ID', sortable: true},
                { field:'title', title:'Title', sortable: true, filterControl: 'input'},
                { field:'category', title:'Category', sortable: true, filterControl: 'input'},
                { field:'tags', title:'Tags', sortable: true, filterControl: 'input'},
                { field:'user.name', title:'Author', sortable: true, filterControl: 'input'},
                { field:'status', title:'status', sortable: true, filterControl: 'select'},
                {
                    field: 'action',
                    title: 'Actions',
                    align: 'center',
                    width: '140px',
                    clickToSelect: false,
                    formatter: function(e, value, row){
                        return '<button class="btn btn-sm btn-info mr-1 restore"><i class="fas fa-eye"></i></button><button class="btn btn-sm btn-warning mr-1 edit"><i class="fas fa-edit"></i></button><button class="btn btn-sm btn-danger mr-1 destroy"><i class="fas fa-trash"></i></button>'
                    },
                    events:{
                        'click .restore': function(e, value, row){
                            return window.location.assign('/recycle-posts/'+row.id)
                        },
                        
                        'click .remove': function(e, value, row){
                            axios.post('/recycle-posts/',{
                                id: row.id
                            })
                            return window.location.replace('/assign.posts/posts.trash')
                        },
                    }
                }
            ]
        }
    },
    created(){
        this.myPosts = JSON.parse(this.posts)
    },
    methods:{
        checkPosts(type){
            this.mySelections = []
            let checkBoxes = document.getElementsByName('id')
            for (let index = 0; index < checkBoxes.length; index++){
                if(checkBoxes[index].type == 'checkbox' && checkBoxes[index].checked == true){
                    this.mySelections.push(checkBoxes[index].value)
                }
            }
            if(type == 'delete'){
                this.deletePosts()
            }else{
                this.restorePosts()
            }
            return window.location.replace('/assign-posts/posts.trash')
        },
        restorePosts(){
            this.mySelections.forEach(function(item){
                axios.get('/recycle-posts/'+item)
            })
        },
        deletePosts(){
            this.mySelections.forEach(function(item){
                axios.post('/recycle-posts',{
                    id: item,
                })
            })
        }
    }
}
</script>

<style>

</style>