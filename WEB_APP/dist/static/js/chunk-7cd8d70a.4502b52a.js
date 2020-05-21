(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-7cd8d70a"],{"085e":function(e,t,a){"use strict";a.d(t,"f",(function(){return n})),a.d(t,"a",(function(){return i})),a.d(t,"b",(function(){return l})),a.d(t,"c",(function(){return r})),a.d(t,"e",(function(){return s})),a.d(t,"d",(function(){return c}));var o=a("b775");function n(e){return Object(o["a"])({url:"inbound",method:"get",params:e})}function i(e){return Object(o["a"])({url:"inbound/detail",method:"get",params:e})}function l(e){return Object(o["a"])({url:"inbound/add",method:"post",params:e})}function r(e){return Object(o["a"])({url:"inbound/delete",method:"delete",params:e})}function s(e){return Object(o["a"])({url:"inbound/detail",method:"put",params:e})}function c(e){return Object(o["a"])({url:"inbound/detail",method:"delete",params:e})}},1:function(e,t){},2:function(e,t){},3:function(e,t){},"3a0c":function(e,t,a){},"5d5f":function(e,t,a){"use strict";a.r(t);var o=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"app-container"},[a("el-form",{ref:"form",attrs:{rules:e.formRules,inline:!0,model:e.inBoundForm,"label-width":"120px"}},[a("el-card",{staticClass:"box-card"},[a("el-form-item",{attrs:{label:"客户参考号",prop:"ref_no"}},[a("el-input",{attrs:{disabled:e.formDisable},model:{value:e.inBoundForm.ref_no,callback:function(t){e.$set(e.inBoundForm,"ref_no",t)},expression:"inBoundForm.ref_no"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"客户编码",prop:"customer_id"}},[a("el-input",{attrs:{disabled:e.formDisable},model:{value:e.inBoundForm.customer_id,callback:function(t){e.$set(e.inBoundForm,"customer_id",t)},expression:"inBoundForm.customer_id"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"创建日期",prop:"booking_date"}},[a("el-date-picker",{attrs:{type:"datetime",placeholder:"选择日期时间",disabled:e.formDisable,format:"yyyy-MM-dd HH:mm:ss"},model:{value:e.inBoundForm.booking_date,callback:function(t){e.$set(e.inBoundForm,"booking_date",t)},expression:"inBoundForm.booking_date"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"仓库编码",prop:"warehouse_code"}},[a("el-select",{attrs:{loading:e.selectLoading,placeholder:"请选择",disabled:e.formDisable},on:{focus:e.getWarehouseList},model:{value:e.inBoundForm.warehouse_code,callback:function(t){e.$set(e.inBoundForm,"warehouse_code",t)},expression:"inBoundForm.warehouse_code"}},e._l(e.warehouseList,(function(e,t){return a("el-option",{key:t,attrs:{label:e.warehouse_code,value:e.warehouse_code}})})),1)],1)],1),e._v(" "),a("el-card",{staticClass:"box-card",staticStyle:{"margin-top":"20px"}},[a("div",{staticClass:"clearfix",attrs:{slot:"header"},slot:"header"},["create"===e.status?a("el-button",{attrs:{icon:"el-icon-plus",size:"small",plain:""},on:{click:function(t){return e.handleCreate("form")}}},[e._v("增加")]):e._e(),e._v(" "),"create"===e.status?a("custom",{attrs:{"on-success":e.handleUploadSuccess}}):e._e(),e._v(" "),"create"===e.status?a("el-link",{staticStyle:{"margin-left":"10px"},attrs:{href:e.excelTemplateUrl,type:"warning",target:"_blank"}},[e._v("Excel模板下载")]):e._e()],1),e._v(" "),a("div",[a("el-table",{ref:"inBoundTable",staticStyle:{width:"100%"},attrs:{data:e.booking_detail,stripe:!0,border:!0,"header-cell-style":{background:"#ebeef5"},"highlight-current-row":"","row-style":{cursor:"pointer"}},on:{"row-click":e.selectRowFunc}},[a("el-table-column",{attrs:{type:"index",align:"center",label:"序号",width:"55"}}),e._v(" "),a("el-table-column",{attrs:{prop:"ref_no",label:"客户参考号",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{prop:"po_no",label:"PO#",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{prop:"qty_case",label:"数量/箱数",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{align:"center",prop:"country",label:"国家"}}),e._v(" "),a("el-table-column",{attrs:{align:"center",prop:"case_length",label:"长"}}),e._v(" "),a("el-table-column",{attrs:{align:"center",prop:"case_width",label:"宽"}}),e._v(" "),a("el-table-column",{attrs:{align:"center",prop:"case_height",label:"高"}}),e._v(" "),a("el-table-column",{attrs:{align:"center",prop:"case_weight",label:"重"}}),e._v(" "),"update"===e.status?a("el-table-column",{attrs:{align:"center",label:"操作"},scopedSlots:e._u([{key:"default",fn:function(t){var o=t.row;return[a("el-button",{attrs:{type:"primary",size:"mini"},on:{click:function(t){return e.handleEdit(o)}}},[e._v("编辑")]),e._v(" "),a("el-button",{attrs:{type:"danger",size:"mini"},on:{click:function(t){return e.handleDelete(o)}}},[e._v("删除")])]}}],null,!1,116640679)}):e._e()],1)],1)])],1),e._v(" "),a("el-dialog",{attrs:{title:"提示",visible:e.dialogVisible,width:"35%"},on:{"update:visible":function(t){e.dialogVisible=t}}},[a("el-form",{ref:"dialogForm",attrs:{inline:!0,model:e.dialogForm,"label-width":"80px"}},[a("el-form-item",{attrs:{label:"客户参考号"}},[a("el-input",{attrs:{disabled:""},model:{value:e.inBoundForm.ref_no,callback:function(t){e.$set(e.inBoundForm,"ref_no",t)},expression:"inBoundForm.ref_no"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"PO#"}},[a("el-input",{model:{value:e.dialogForm.po_no,callback:function(t){e.$set(e.dialogForm,"po_no",t)},expression:"dialogForm.po_no"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"国家"}},[a("el-input",{model:{value:e.dialogForm.country,callback:function(t){e.$set(e.dialogForm,"country",t)},expression:"dialogForm.country"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"数量/箱数"}},[a("el-input",{model:{value:e.dialogForm.qty_case,callback:function(t){e.$set(e.dialogForm,"qty_case",t)},expression:"dialogForm.qty_case"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"长"}},[a("el-input",{model:{value:e.dialogForm.case_length,callback:function(t){e.$set(e.dialogForm,"case_length",t)},expression:"dialogForm.case_length"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"宽"}},[a("el-input",{model:{value:e.dialogForm.case_width,callback:function(t){e.$set(e.dialogForm,"case_width",t)},expression:"dialogForm.case_width"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"高"}},[a("el-input",{model:{value:e.dialogForm.case_height,callback:function(t){e.$set(e.dialogForm,"case_height",t)},expression:"dialogForm.case_height"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"重"}},[a("el-input",{model:{value:e.dialogForm.case_weight,callback:function(t){e.$set(e.dialogForm,"case_weight",t)},expression:"dialogForm.case_weight"}})],1)],1),e._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(t){e.dialogVisible=!1}}},[e._v("取 消")]),e._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:function(t){"create"===e.status?e.create():e.update()}}},[e._v("确 定")])],1)],1)],1)},n=[],i=(a("a481"),a("085e")),l=a("b775");function r(){return Object(l["a"])({url:"warehouse",method:"get"})}var s=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticStyle:{display:"inline-block"}},[a("input",{ref:"excel-upload-input",staticClass:"excel-upload-input",attrs:{type:"file",accept:".xlsx, .xls"},on:{change:e.handleClick}}),e._v(" "),a("el-button",{staticStyle:{"margin-left":"10px"},attrs:{loading:e.loading,size:"mini",type:"primary",plain:"",icon:"el-icon-upload"},on:{click:e.handleUpload}},[e._v("导入")])],1)},c=[],u=(a("7f7f"),a("1146")),d=a.n(u),m={props:{beforeUpload:Function,onSuccess:Function},data:function(){return{loading:!1,excelData:{header:null,results:null}}},methods:{generateData:function(e){var t=e.header,a=e.results;this.excelData.header=t,this.excelData.results=a,this.onSuccess&&this.onSuccess(this.excelData)},handleUpload:function(){this.$refs["excel-upload-input"].click()},handleClick:function(e){var t=e.target.files,a=t[0];a&&this.upload(a)},upload:function(e){if(this.$refs["excel-upload-input"].value=null,this.beforeUpload){var t=this.beforeUpload(e);t&&this.readerData(e)}else this.readerData(e)},readerData:function(e){var t=this;return this.loading=!0,new Promise((function(a,o){var n=new FileReader;n.onload=function(e){var o=e.target.result,n=d.a.read(o,{type:"array"}),i=n.SheetNames[0],l=n.Sheets[i],r=t.getHeaderRow(l),s=d.a.utils.sheet_to_json(l);t.generateData({header:r,results:s}),t.loading=!1,a()},n.readAsArrayBuffer(e)}))},getHeaderRow:function(e){var t,a=[],o=d.a.utils.decode_range(e["!ref"]),n=o.s.r;for(t=o.s.c;t<=o.e.c;++t){var i=e[d.a.utils.encode_cell({c:t,r:n})],l="UNKNOWN "+t;i&&i.t&&(l=d.a.utils.format_cell(i)),a.push(l)}return a},isExcel:function(e){return/\.(xlsx|xls|csv)$/.test(e.name)}}},f=m,g=(a("64b2"),a("2877")),b=Object(g["a"])(f,s,c,!1,null,"d97b9872",null),h=b.exports,p={name:"InBoundCreateOrUpdate",components:{Custom:h},data:function(){return{loading:!1,selectLoading:!1,formDisable:!1,inBoundParams:null,excelTemplateUrl:"",status:"",inBoundForm:{ref_no:"",customer_id:"",booking_date:new Date,warehouse_code:"",booking_detail:null,booking_detail_total:""},dialogForm:{ref_no:"",po_no:"",country:"",qty_case:"",case_length:"",case_width:"",case_height:"",case_weight:""},booking_detail:null,warehouseList:null,formRules:{ref_no:[{required:!0,message:"客户参考号必填",trigger:"blur"}],customer_id:[{required:!0,message:"客户编码必填",trigger:"blur"}],booking_date:[{required:!0,message:"创建日期必填",trigger:"blur"}],warehouse_code:[{required:!0,message:"仓库编码必填",trigger:"blur"}]},dialogVisible:!1}},created:function(){this.status=this.$route.params.status,this.inBoundParams=this.$route.params,this.checkInBoundStatus(),this.getExcelTemplate()},methods:{checkInBoundStatus:function(){"update"===this.status?(this.getDetailList(),this.formDisable=!0):this.inBoundForm={}},getExcelTemplate:function(){var e="http://120.78.142.77:8081/v1",t=e.replace("/v1","");this.excelTemplateUrl=t+"/assets/excel/detail-list-template.xlsx"},getWarehouseList:function(){var e=this;this.selectLoading=!0,r().then((function(t){e.warehouseList=t.data,e.selectLoading=!1}))},getDetailList:function(){var e=this;this.loading=!0,Object(i["a"])({booking_id:this.inBoundParams.booking_id}).then((function(t){null!==t.data&&(e.inBoundForm.warehouse_code=t.data.warehouse_code,e.inBoundForm.customer_id=t.data.customer_id,e.inBoundForm.ref_no=t.data.ref_no,e.inBoundForm.booking_date=t.data.booking_date,e.booking_detail=t.data.details),e.loading=!1}))},selectRowFunc:function(e){this.$refs.inBoundTable.toggleRowSelection(e)},handleCreate:function(e){var t=this;this.$refs[e].validate((function(e){if(!e)return!1;t.dialogVisible=!0}))},create:function(e){var t=this;if("create"===this.status){var a=[];a.push(this.dialogForm),this.inBoundForm.booking_detail=a,Object(i["b"])(this.inBoundForm).then((function(e){2001===e.code?(t.$message({message:"写入成功",type:"success"}),t.dialogVisible=!1):t.$message.error("写入失败")}))}},handleUploadSuccess:function(e){var t=this,a=e.results;e.header;this.$refs.form.validate((function(e){if(!e)return!1;t.inBoundForm.booking_detail=a,Object(i["b"])(t.inBoundForm).then((function(e){2001===e.code?(t.$message({message:"写入成功",type:"success"}),t.dialogVisible=!1):t.$message.error("写入失败")}))}))},handleEdit:function(e){this.dialogVisible=!0,this.dialogForm=e},update:function(){var e=this,t={inboundid:"",booking_detail:null},a=[];a.push(this.dialogForm),t.inboundid=this.dialogForm.inboundid,t.booking_detail=a,Object(i["e"])(t).then((function(t){2001===t.code?(e.$message({message:"写入成功",type:"success"}),e.dialogVisible=!1):e.$message.error("写入失败")}))},handleDelete:function(e){var t=this;Object(i["d"])({inboundid:e.inboundid}).then((function(e){2001===e.code?(t.$message({message:"删除成功",type:"success"}),t.getDetailList()):t.$message.error("删除失败")}))}}},_=p,v=Object(g["a"])(_,o,n,!1,null,"cabd8eb0",null);t["default"]=v.exports},"64b2":function(e,t,a){"use strict";var o=a("3a0c"),n=a.n(o);n.a}}]);