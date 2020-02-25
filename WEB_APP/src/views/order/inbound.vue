<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.customer_id" clearable :placeholder="$t('table.customer_id')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-input v-model="listQuery.ref_no" clearable :placeholder="$t('table.ref_no')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-date-picker
        v-model="pickerDate"
        class="filter-item"
        type="daterange"
        align="right"
        unlink-panels
        range-separator="至"
        start-placeholder="开始日期"
        end-placeholder="结束日期"
        value-format="yyyy-MM-dd"
        :picker-options="pickerOptions"
        @change="pickerDateValue"
      />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
    </div>

    <el-row class="table-style">
      <el-col class="table-button">
        <el-button v-waves plain icon="el-icon-plus" size="small" @click="handleCreate()">创建订单</el-button>
        <!-- <el-button v-waves plain type="primary" icon="el-icon-edit" size="small">编辑</el-button> -->
        <el-button v-waves plain type="danger" icon="el-icon-delete" size="small">批量删除</el-button>
        <el-button v-waves plain type="success" icon="el-icon-tickets" size="small">收货清单</el-button>
      </el-col>
      <el-col>
        <el-table
          :key="tableKey"
          v-loading="listLoading"
          :data="list"
          border
          fit
          highlight-current-row
          style="width: 100%;"
        >
          <el-table-column
            type="selection"
            width="55"
            align="center"
          />
          <el-table-column :label="$t('table.customer_id')" align="center">
            <template slot-scope="{row}">
              <span>{{ row.customer_id }}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.ref_no')" align="center">
            <template slot-scope="{row}">
              <span>{{ row.ref_no }}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.create_date')" align="center" prop="create_data" sortable>
            <template slot-scope="{row}">
              <span>{{ row.create_date | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.booking_status')" align="center">
            <template slot-scope="{row}">
              <el-tag :type="row.booking_status | statusFilter">
                {{ row.booking_status }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.order_qty')" align="center">
            <template slot-scope="{row}">
              <span>{{ row.order_qty }}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.booking_date')" align="center" prop="booking_data" sortable>
            <template slot-scope="{row}">
              <span>{{ row.booking_date | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.actions')" align="center" width="230" class-name="small-padding fixed-width">
            <template slot-scope="{row}">
              <el-button type="primary" size="mini" @click="handleUpdate(row)">
                {{ $t('table.edit') }}
              </el-button>
              <el-button v-if="row.status!='deleted'" size="mini" type="danger" @click="handleModifyStatus(row,'deleted')">
                {{ $t('table.delete') }}
              </el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.page_limit" @pagination="getList" />

    <!-- 订单弹出框 -->
    <el-dialog :title="textMap[dialogStatus]" top="10vh" :visible.sync="dialogFormVisible">
      <el-form ref="dialogForm" :rules="rules" :inline="true" :model="temp" label-position="right" label-width="100px">
        <el-row>
          <el-divider content-position="left">订单信息</el-divider>
          <el-form-item :label="$t('table.customer_id')" prop="customer_id">
            <el-input v-model="temp.customer_id" />
          </el-form-item>
          <el-form-item :label="$t('table.booking_date')" prop="booking_date">
            <el-date-picker
              v-model="temp.booking_date"
              type="datetime"
              placeholder="选择日期时间"
            />
          </el-form-item>
          <el-form-item :label="$t('table.warehouse_code')" prop="warehouse_code">
            <el-input v-model="temp.warehouse_code" />
          </el-form-item>
          <!-- <el-form-item :label="$t('table.title')" prop="title">
            <el-input v-model="temp.title" />
          </el-form-item> -->
        </el-row>
        <el-row>
          <el-divider content-position="left">货物信息</el-divider>
          <el-col class="table-button">
            <el-button v-waves plain icon="el-icon-plus" size="mini" @click="handleDialogCreate()">增加</el-button>
            <!-- <el-button v-waves plain type="primary" icon="el-icon-edit" size="small">编辑</el-button> -->
            <el-button v-waves plain type="danger" icon="el-icon-delete" size="mini" @click="handleDialogDelete()">删除</el-button>
            <!-- <el-button v-waves plain type="success" icon="el-icon-upload" size="mini" @click="handleDialogUpload">导入</el-button>-->
            <upload-excel-component class="dialogUpload" :on-success="handleSuccess" :before-upload="beforeUpload" />
          </el-col>
          <el-col>
            <el-table
              :key="diaLogKey"
              v-loading="dialogListLoading"
              :data="dialogList"
              border
              fit
              highlight-current-row
              style="width: 100%;"
              @selection-change="handleDialogSelectionChange"
            >
              <el-table-column
                type="selection"
                width="55"
                align="center"
              />
              <!-- <el-table-column :label="$t('table.booking_id')" align="center">
                <template slot-scope="{row}">
                  <span>{{ row.booking_id }}</span>
                </template>
              </el-table-column> -->
              <el-table-column :label="$t('table.ref_no')" prop="ref_no" align="center">
                <template slot-scope="{row}">
                  <span>{{ row.ref_no }}</span>
                </template>
              </el-table-column>
              <el-table-column :label="$t('table.po_no')" prop="po_no" align="center">
                <template slot-scope="{row}">
                  <span>{{ row.po_no }}</span>
                </template>
              </el-table-column>
              <el-table-column :label="$t('table.order_qty')" prop="order_qty" align="center">
                <template slot-scope="{row}">
                  <span>{{ row.order_qty }}</span>
                </template>
              </el-table-column>
              <el-table-column :label="$t('table.case_length')" prop="case_length" align="center">
                <template slot-scope="{row}">
                  <span>{{ row.case_length }}</span>
                </template>
              </el-table-column>
              <el-table-column :label="$t('table.case_width')" prop="case_width" align="center">
                <template slot-scope="{row}">
                  <span>{{ row.case_width }}</span>
                </template>
              </el-table-column>
              <el-table-column :label="$t('table.case_height')" prop="case_height" align="center">
                <template slot-scope="{row}">
                  <span>{{ row.case_height }}</span>
                </template>
              </el-table-column>
              <el-table-column :label="$t('table.case_weight')" prop="case_weight" align="center">
                <template slot-scope="{row}">
                  <span>{{ row.case_weight }}</span>
                </template>
              </el-table-column>
            </el-table>
          </el-col>
        </el-row>
        <!--当订单状态为编辑时获取数据-->
        <pagination v-if="dialogStatus==='update' && dialogTotal>0" :total="dialogTotal" :page.sync="dialogListQuery.page" :limit.sync="dialogListQuery.page_limit" @pagination="getDialogList" />
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">
          {{ $t('table.cancel') }}
        </el-button>
        <el-button type="primary" @click="dialogStatus==='create'?createData():updateData()">
          {{ $t('table.confirm') }}
        </el-button>
      </div>
    </el-dialog>

    <!-- 弹出框内弹出框 -->
    <el-dialog :visible.sync="dialogFormDataVisiable" title="增加货物" width="32%">
      <el-form ref="dialogDataForm" :rules="rules" :inline="true" :model="temp" label-position="right" label-width="50px">
        <el-row>
          <el-col>
            <el-form-item :label="$t('table.ref_no')" prop="ref_no">
              <el-input v-model="temp.ref_no" />
            </el-form-item>
            <el-form-item :label="$t('table.po_no')" prop="po_no">
              <el-input v-model="temp.po_no" />
            </el-form-item>
          </el-col>
          <el-col>
            <el-form-item :label="$t('table.order_qty')" prop="order_qty">
              <el-input v-model="temp.order_qty" />
            </el-form-item>
            <el-form-item :label="$t('table.case_length')" prop="case_length">
              <el-input v-model="temp.case_length" />
            </el-form-item>
            <el-form-item :label="$t('table.case_width')" prop="case_width">
              <el-input v-model="temp.case_width" />
            </el-form-item>
            <el-form-item :label="$t('table.case_height')" prop="case_height">
              <el-input v-model="temp.case_height" />
            </el-form-item>
            <el-form-item :label="$t('table.case_weight')" prop="case_weight">
              <el-input v-model="temp.case_weight" />
            </el-form-item>
          </el-col>
        </el-row>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="innerDialogConfirm">{{ $t('table.confirm') }}</el-button>
      </span>
    </el-dialog>

    <el-dialog :visible.sync="dialogPvVisible" title="Reading statistics">
      <el-table :data="pvData" border fit highlight-current-row style="width: 100%">
        <el-table-column prop="key" label="Channel" />
        <el-table-column prop="pv" label="Pv" />
      </el-table>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogPvVisible = false">{{ $t('table.confirm') }}</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { tableList, dialogList, fetchPv, createArticle, updateArticle } from '@/api/inbound'
import waves from '@/directive/waves' // waves directive
import { parseTime } from '@/utils'
import Pagination from '@/components/Pagination' // secondary package based on el-pagination
import UploadExcelComponent from '@/components/UploadExcel/custom.vue'

// const calendarTypeOptions = [
//   { key: 'CN', display_name: 'China' },
//   { key: 'US', display_name: 'USA' },
//   { key: 'JP', display_name: 'Japan' },
//   { key: 'EU', display_name: 'Eurozone' }
// ]

// arr to obj, such as { CN : "China", US : "USA" }
// const calendarTypeKeyValue = calendarTypeOptions.reduce((acc, cur) => {
//   acc[cur.key] = cur.display_name
//   return acc
// }, {})

export default {
  name: 'ComplexTable',
  components: { Pagination, UploadExcelComponent },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        NEW: 'warning',
        RECEIPTING: 'success'
      }
      return statusMap[status]
    }
    // typeFilter(type) {
    //   return calendarTypeKeyValue[type]
    // }
  },
  data() {
    return {
      tableKey: 0,
      list: null,
      diaLogKey: 0,
      dialogQuery: {
        customer_id: null,
        warehouse_code: null,
        booking_date: null
      },
      dialogList: [],
      dialogMultipleSelection: [],
      dialogListQuery: {
        page: 1,
        page_limit: 5,
        customer_id: null,
        warehouse_code: null
      },
      dialogListTemp: null,
      total: 0,
      dialogTotal: 0,
      pickerDate: null,
      listLoading: true,
      dialogListLoading: true,
      pickerOptions: {
        shortcuts: [{
          text: '最近一周',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近一个月',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近三个月',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
            picker.$emit('pick', [start, end])
          }
        }]
      },
      listQuery: {
        page: 1,
        page_limit: 20,
        start_time: null,
        end_time: null
      },
      temp: {
        customer_id: null,
        warehouse_code: null,
        booking_date: new Date(),
        order_qty: null,
        ref_no: null,
        po_no: null,
        case_length: null,
        case_width: null,
        case_height: null,
        case_weight: null
      },
      testTemp: [],
      dialogFormVisible: false,
      // 弹出框内弹出框
      dialogFormDataVisiable: false,
      dialogStatus: '',
      textMap: {
        update: '编辑',
        create: '创建'
      },
      dialogPvVisible: false,
      pvData: [],
      rules: {
        customer_id: [{ required: true, message: '客户参考号必填', trigger: 'blur' }],
        // booking_date: [{ type: 'date', required: true, message: '日期必选', trigger: 'blur' }],
        warehouse_code: [{ required: true, message: '仓库代码必填', trigger: 'blur' }]
      },
      downloadLoading: false
    }
  },
  created() {
    this.getList()
  },
  methods: {
    // 获取入库数据
    getList() {
      this.listLoading = true
      tableList(this.listQuery).then(response => {
        this.list = response.data.data
        this.total = response.data.total

        // Just to simulate the time of the request
        setTimeout(() => {
          this.listLoading = false
        }, 1.5 * 1000)
      })
    },
    // 获取弹出框表格数据
    getDialogList() {
      this.dialogListLoading = true
      dialogList(this.dialogListQuery).then(response => {
        this.dialogList = response.data.data
        this.dialogTotal = response.data.total

        // 设置加载时间
        setTimeout(() => {
          this.dialogListLoading = false
        }, 1.5 * 1000)
      })
    },
    // 弹出框-传递数据
    dialogHandleUpdate() {
      console.log(this.dialogStatus)
      this.dialogList = null
      this.dialogTotal = 0
      this.dialogListLoading = false
    },
    // 选择日期
    pickerDateValue(val) {
      if (val) {
        this.listQuery.start_time = val[0]
        this.listQuery.end_time = val[1]
      } else {
        this.listQuery.start_time = null
        this.listQuery.end_time = null
      }
    },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    handleModifyStatus(row, status) {
      this.$message({
        message: '操作成功',
        type: 'success'
      })
      row.status = status
    },
    // 重置缓存
    resetTemp() {
      this.temp = {
        customer_id: null,
        warehouse_code: null,
        booing_date: new Date(),
        order_qty: null
      }
    },
    // 获取弹出对话框内选择内容
    handleDialogSelectionChange(val) {
      // 获取选中的值交给数据托管
      this.dialogMultipleSelection = val
    },
    // 点击创建订单
    handleCreate() {
      this.resetTemp()
      this.dialogList = null // 清除弹出框数据
      this.dialogStatus = 'create' // 变更弹出框状态
      this.dialogFormVisible = true
      this.dialogListLoading = false // 关闭加载动画
      // this.$nextTick(() => {
      //   this.$refs['dialogDataForm'].clearValidate()
      // })
    },
    // 弹出框-添加
    handleDialogCreate() {
      this.$refs['dialogForm'].validate((valid) => {
        if (valid) {
          this.dialogFormDataVisiable = true
        }
      })
    },
    // 新增货物-确定添加按钮
    innerDialogConfirm() {
      // 获取用户输入值放入对象，然后将对象追加到数组中
      const dialogList = {
        order_qty: this.temp.order_qty,
        ref_no: this.temp.ref_no,
        po_no: this.temp.po_no,
        case_length: this.temp.case_length,
        case_width: this.temp.case_width,
        case_height: this.temp.case_height,
        case_weight: this.temp.case_weight
      }
      // 追加数据
      this.testTemp.push(dialogList)
      // 关闭弹出层输入框
      this.dialogFormDataVisiable = false
      // 刷新加载数据
      this.dialogList = this.testTemp
      // 清除弹出层输入框数据
      // this.temp = null
    },
    // 添加货物信息
    dialogCreate() {
      this.$refs['dialogForm'].validate((valid) => {
        if (valid) {
          this.temp.id = parseInt(Math.random() * 100) + 1024 // mock a id
          this.temp.author = 'vue-element-admin'
          createArticle(this.temp).then(() => {
            this.list.unshift(this.temp)
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '创建成功',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
    handleUpdate(row) {
      this.dialogStatus = 'update'
      this.temp = Object.assign({}, row) // copy obj
      // 赋值给参数
      this.dialogListQuery.customer_id = this.temp.customer_id
      this.dialogListQuery.warehouse_code = this.temp.warehouse_code
      // 获取弹出框数据
      this.getDialogList()
      this.temp.booking_date = new Date(this.temp.booking_date)
      this.dialogFormVisible = true
      this.$nextTick(() => {
        // this.$refs['dialogDataForm'].clearValidate()
        this.$refs['dialogForm'].clearValidate()
      })
    },
    updateData() {
      this.$refs['dialogDataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp)
          tempData.booking_date = +new Date(tempData.booking_date) // change Thu Nov 30 2017 16:41:05 GMT+0800 (CST) to 1512031311464
          updateArticle(tempData).then(() => {
            for (const v of this.list) {
              if (v.id === this.temp.id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, this.temp)
                break
              }
            }
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '更新成功',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
    handleDelete(row) {
      this.$notify({
        title: '成功',
        message: '删除成功',
        type: 'success',
        duration: 2000
      })
      const index = this.list.indexOf(row)
      this.list.splice(index, 1)
    },
    handleDialogDelete() {
      // 从dialogList里移除所选数据即this.dialogMultipleSelection
      console.log(this.dialogMultipleSelection.indexOf(0))
      this.dialogList.splice(0, this.dialogMultipleSelection.length)
      console.log(this.dialogList)
    },
    handleFetchPv(pv) {
      fetchPv(pv).then(response => {
        this.pvData = response.data.pvData
        this.dialogPvVisible = true
      })
    },
    // handleDialogCreate() {
    //   this.resetTemp()
    //   this.$refs['dialogDataForm'].validate((valid) => {
    //     if (valid) {
    //       console.log('123')
    //     }
    //   })
    // },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['timestamp', 'title', 'type', 'importance', 'status']
        const filterVal = ['timestamp', 'title', 'type', 'importance', 'status']
        const data = this.formatJson(filterVal, this.list)
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'table-list'
        })
        this.downloadLoading = false
      })
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    },
    getSortClass: function(key) {
      const sort = this.listQuery.sort
      return sort === `+${key}`
        ? 'ascending'
        : sort === `-${key}`
          ? 'descending'
          : ''
    }
  }
}
</script>
<style lang="scss" scoped>
  .table-style{
    border: 1px solid #eee;
  }
  .table-button{
  margin:15px 0 15px 15px;
}
  .dialogUpload{
    display: inline-block;
  }
</style>
