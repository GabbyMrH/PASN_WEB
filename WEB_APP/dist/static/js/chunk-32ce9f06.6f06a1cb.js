(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-32ce9f06"],{"085e":function(e,t,n){"use strict";n.d(t,"f",(function(){return i})),n.d(t,"a",(function(){return l})),n.d(t,"b",(function(){return o})),n.d(t,"c",(function(){return r})),n.d(t,"e",(function(){return s})),n.d(t,"d",(function(){return u}));var a=n("b775");function i(e){return Object(a["a"])({url:"inbound",method:"get",params:e})}function l(e){return Object(a["a"])({url:"inbound/detail",method:"get",params:e})}function o(e){return Object(a["a"])({url:"inbound/add",method:"post",params:e})}function r(e){return Object(a["a"])({url:"inbound/delete",method:"delete",params:e})}function s(e){return Object(a["a"])({url:"inbound/detail",method:"put",params:e})}function u(e){return Object(a["a"])({url:"inbound/detail",method:"delete",params:e})}},"333d":function(e,t,n){"use strict";var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"pagination-container",class:{hidden:e.hidden}},[n("el-pagination",e._b({attrs:{background:e.background,"current-page":e.currentPage,"page-size":e.pageSize,layout:e.layout,"page-sizes":e.pageSizes,total:e.total},on:{"update:currentPage":function(t){e.currentPage=t},"update:current-page":function(t){e.currentPage=t},"update:pageSize":function(t){e.pageSize=t},"update:page-size":function(t){e.pageSize=t},"size-change":e.handleSizeChange,"current-change":e.handleCurrentChange}},"el-pagination",e.$attrs,!1))],1)},i=[];n("c5f6");Math.easeInOutQuad=function(e,t,n,a){return e/=a/2,e<1?n/2*e*e+t:(e--,-n/2*(e*(e-2)-1)+t)};var l=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(e){window.setTimeout(e,1e3/60)}}();function o(e){document.documentElement.scrollTop=e,document.body.parentNode.scrollTop=e,document.body.scrollTop=e}function r(){return document.documentElement.scrollTop||document.body.parentNode.scrollTop||document.body.scrollTop}function s(e,t,n){var a=r(),i=e-a,s=20,u=0;t="undefined"===typeof t?500:t;var c=function e(){u+=s;var r=Math.easeInOutQuad(u,a,i,t);o(r),u<t?l(e):n&&"function"===typeof n&&n()};c()}var u={name:"Pagination",props:{total:{required:!0,type:Number},page:{type:Number,default:1},limit:{type:Number,default:20},pageSizes:{type:Array,default:function(){return[5,10,20,30,50]}},layout:{type:String,default:"total, sizes, prev, pager, next, jumper"},background:{type:Boolean,default:!0},autoScroll:{type:Boolean,default:!0},hidden:{type:Boolean,default:!1}},computed:{currentPage:{get:function(){return this.page},set:function(e){this.$emit("update:page",e)}},pageSize:{get:function(){return this.limit},set:function(e){this.$emit("update:limit",e)}}},methods:{handleSizeChange:function(e){this.$emit("pagination",{page:this.currentPage,limit:e}),this.autoScroll&&s(0,800)},handleCurrentChange:function(e){this.$emit("pagination",{page:e,limit:this.pageSize}),this.autoScroll&&s(0,800)}}},c=u,d=(n("9985"),n("2877")),p=Object(d["a"])(c,a,i,!1,null,"07f7dac8",null);t["a"]=p.exports},6724:function(e,t,n){"use strict";n("8d41");var a="@@wavesContext";function i(e,t){function n(n){var a=Object.assign({},t.value),i=Object.assign({ele:e,type:"hit",color:"rgba(0, 0, 0, 0.15)"},a),l=i.ele;if(l){l.style.position="relative",l.style.overflow="hidden";var o=l.getBoundingClientRect(),r=l.querySelector(".waves-ripple");switch(r?r.className="waves-ripple":(r=document.createElement("span"),r.className="waves-ripple",r.style.height=r.style.width=Math.max(o.width,o.height)+"px",l.appendChild(r)),i.type){case"center":r.style.top=o.height/2-r.offsetHeight/2+"px",r.style.left=o.width/2-r.offsetWidth/2+"px";break;default:r.style.top=(n.pageY-o.top-r.offsetHeight/2-document.documentElement.scrollTop||document.body.scrollTop)+"px",r.style.left=(n.pageX-o.left-r.offsetWidth/2-document.documentElement.scrollLeft||document.body.scrollLeft)+"px"}return r.style.backgroundColor=i.color,r.className="waves-ripple z-active",!1}}return e[a]?e[a].removeHandle=n:e[a]={removeHandle:n},n}var l={bind:function(e,t){e.addEventListener("click",i(e,t),!1)},update:function(e,t){e.removeEventListener("click",e[a].removeHandle,!1),e.addEventListener("click",i(e,t),!1)},unbind:function(e){e.removeEventListener("click",e[a].removeHandle,!1),e[a]=null,delete e[a]}},o=function(e){e.directive("waves",l)};window.Vue&&(window.waves=l,Vue.use(o)),l.install=o;t["a"]=l},"85e2":function(e,t,n){"use strict";n.r(t);var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"app-container"},[n("div",{staticClass:"filter-container"},[n("el-input",{staticClass:"filter-item",staticStyle:{width:"200px"},attrs:{clearable:"",placeholder:e.$t("table.ref_no")},nativeOn:{keyup:function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter")?null:e.handleFilter(t)}},model:{value:e.listQuery.ref_no,callback:function(t){e.$set(e.listQuery,"ref_no",t)},expression:"listQuery.ref_no"}}),e._v(" "),n("el-input",{staticClass:"filter-item",staticStyle:{width:"200px"},attrs:{clearable:"",placeholder:e.$t("table.booking_no")},nativeOn:{keyup:function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter")?null:e.handleFilter(t)}},model:{value:e.listQuery.booking_no,callback:function(t){e.$set(e.listQuery,"booking_no",t)},expression:"listQuery.booking_no"}}),e._v(" "),n("el-date-picker",{staticClass:"filter-item",attrs:{type:"daterange",align:"right","unlink-panels":"","range-separator":"至","start-placeholder":"开始日期","end-placeholder":"结束日期","value-format":"yyyy-MM-dd","picker-options":e.pickerOptions},on:{change:e.pickerDateValue},model:{value:e.pickerDate,callback:function(t){e.pickerDate=t},expression:"pickerDate"}}),e._v(" "),n("el-button",{directives:[{name:"waves",rawName:"v-waves"}],staticClass:"filter-item",attrs:{type:"primary",icon:"el-icon-search"},on:{click:e.handleFilter}},[e._v("\n      "+e._s(e.$t("table.search"))+"\n    ")])],1),e._v(" "),n("el-row",{staticClass:"table-style"},[n("el-col",{staticClass:"table-button"},[n("router-link",{attrs:{to:{name:"InBoundCreateOrUpdate",params:e.createOrUpdateData}}},[n("el-button",{directives:[{name:"waves",rawName:"v-waves"}],attrs:{plain:"",icon:"el-icon-plus",size:"small"},on:{click:function(t){return e.handleCreate()}}},[e._v("创建订单")])],1)],1),e._v(" "),n("el-col",[n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.listLoading,expression:"listLoading"}],key:e.tableKey,staticStyle:{width:"100%"},attrs:{data:e.list,border:"",fit:"","highlight-current-row":"","header-cell-style":{background:"#ebeef5"}}},[n("el-table-column",{attrs:{type:"index",width:"55",align:"center",label:"序号"}}),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.ref_no"),prop:"ref_no",align:"center"}}),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.booking_no"),prop:"booking_no",align:"center"}}),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.booking_date"),align:"center",prop:"booking_data",sortable:""},scopedSlots:e._u([{key:"default",fn:function(t){var a=t.row;return[n("span",[e._v(e._s(e._f("parseTime")(a.booking_date,"{y}-{m}-{d} {h}:{i}")))])]}}])}),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.booking_status"),align:"center",prop:"booking_status"},scopedSlots:e._u([{key:"default",fn:function(t){var a=t.row;return[n("el-tag",{attrs:{type:e._f("statusFilter")(a.booking_status)}},[e._v("\n              "+e._s(a.booking_status)+"\n            ")])]}}])}),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.order_qty"),align:"center",prop:"order_qty",sortable:""}}),e._v(" "),n("el-table-column",{attrs:{label:"收货日期",align:"center",prop:"booking_date",sortable:""},scopedSlots:e._u([{key:"default",fn:function(t){var a=t.row;return[n("span",[e._v(e._s(e._f("parseTime")(a.booking_date,"{y}-{m}-{d} {h}:{i}")))])]}}])}),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.customer_id"),align:"center",prop:"customer_id"}}),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.warehouse_code"),align:"center",prop:"warehouse_code"}}),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.otherActions"),align:"center"}},[[n("el-tooltip",{attrs:{effect:"dark",content:"收货报告",placement:"top"}},[n("el-button",{attrs:{icon:"el-icon-tickets",size:"mini",round:""}})],1),e._v(" "),n("el-tooltip",{attrs:{effect:"dark",content:"QC下载",placement:"top"}},[n("el-button",{attrs:{icon:"el-icon-picture-outline",size:"mini",round:""}})],1)]],2),e._v(" "),n("el-table-column",{attrs:{label:e.$t("table.actions"),align:"center",width:"160","class-name":"small-padding fixed-width"},scopedSlots:e._u([{key:"default",fn:function(t){var a=t.row;return[n("router-link",{attrs:{to:{name:"InBoundCreateOrUpdate",params:e.createOrUpdateData}}},["NEW"==a.booking_status?n("el-button",{attrs:{type:"primary",size:"mini"},on:{click:function(t){return e.handleUpdate(a)}}},[e._v("\n                "+e._s(e.$t("table.edit"))+"\n              ")]):e._e()],1),e._v(" "),"RECEIPTING"==a.booking_status?n("el-button",{attrs:{size:"mini",type:"danger"},on:{click:function(t){return e.handleDelete(a)}}},[e._v("\n              "+e._s(e.$t("table.delete"))+"\n            ")]):e._e()]}}])})],1)],1)],1),e._v(" "),n("pagination",{directives:[{name:"show",rawName:"v-show",value:e.total>0,expression:"total>0"}],attrs:{total:e.total,page:e.listQuery.page,limit:e.listQuery.page_limit},on:{"update:page":function(t){return e.$set(e.listQuery,"page",t)},"update:limit":function(t){return e.$set(e.listQuery,"page_limit",t)},pagination:e.getList}})],1)},i=[],l=n("085e"),o=n("6724"),r=n("5f87"),s=n("c24f"),u=n("333d"),c={name:"InBound",components:{Pagination:u["a"]},directives:{waves:o["a"]},filters:{statusFilter:function(e){var t={NEW:"warning",RECEIPTING:"success"};return t[e]}},data:function(){return{loginUser:"",excelTemplateUrl:"",tableKey:0,list:null,total:0,pickerDate:null,listLoading:!0,pickerOptions:{shortcuts:[{text:"最近一周",onClick:function(e){var t=new Date,n=new Date;n.setTime(n.getTime()-6048e5),e.$emit("pick",[n,t])}},{text:"最近一个月",onClick:function(e){var t=new Date,n=new Date;n.setTime(n.getTime()-2592e6),e.$emit("pick",[n,t])}},{text:"最近三个月",onClick:function(e){var t=new Date,n=new Date;n.setTime(n.getTime()-7776e6),e.$emit("pick",[n,t])}}]},listQuery:{page:1,page_limit:20,start_time:null,end_time:null},createOrUpdateData:{status:"",booking_id:null},temp:{customer_id:null,warehouse_code:null,booking_date:new Date,order_qty:null,qty_case:null,ref_no:null,po_no:null,case_length:null,case_width:null,case_height:null,case_weight:null},textMap:{update:"编辑",create:"创建"}}},created:function(){this.getList(),this.getLoginUser()},methods:{getLoginUser:function(){var e=this;Object(s["a"])(Object(r["a"])()).then((function(t){e.loginUser=t.data}))},getList:function(){var e=this;this.listLoading=!0,Object(l["f"])(this.listQuery).then((function(t){e.list=t.data.data,e.total=t.data.total,e.listLoading=!1}))},pickerDateValue:function(e){e?(this.listQuery.start_time=e[0],this.listQuery.end_time=e[1]):(this.listQuery.start_time=null,this.listQuery.end_time=null)},handleFilter:function(){this.listQuery.page=1,this.getList()},resetTemp:function(){this.temp={ref_no:null,warehouse_code:null,booing_date:new Date,order_qty:null}},handleCreate:function(){this.createOrUpdateData.status="create"},handleUpdate:function(e){this.createOrUpdateData.status="update",this.createOrUpdateData.booking_id=e.booking_id},handleDelete:function(e){var t=this;Object(l["c"])(e).then((function(e){2001===e.code?(t.$message({message:"删除成功",type:"success"}),t.getList()):t.$message.error("删除失败")}))}}},d=c,p=(n("9d59"),n("2877")),f=Object(p["a"])(d,a,i,!1,null,"0f18363b",null);t["default"]=f.exports},"89e4":function(e,t,n){},"8d41":function(e,t,n){},9985:function(e,t,n){"use strict";var a=n("dea7"),i=n.n(a);i.a},"9d59":function(e,t,n){"use strict";var a=n("89e4"),i=n.n(a);i.a},dea7:function(e,t,n){}}]);