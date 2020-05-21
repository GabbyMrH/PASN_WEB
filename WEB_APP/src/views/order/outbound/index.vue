<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.ref_no" clearable :placeholder="$t('table.ref_no')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-input v-model="listQuery.order_no" clearable placeholder="出库单号" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
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
        <router-link :to="{ name:'OutBoundCreateOrUpdate', params: createOrUpdateData }">
          <el-button v-waves plain icon="el-icon-plus" size="small" @click="handleCreate()">创建订单</el-button>
        </router-link>
        <!-- <el-button v-waves plain type="primary" icon="el-icon-edit" size="small">编辑</el-button> -->
        <!-- <el-button v-waves plain type="danger" icon="el-icon-delete" size="small">批量删除</el-button> -->
        <!-- <el-button v-waves plain type="success" icon="el-icon-tickets" size="small">收货报告</el-button> -->
      </el-col>
      <el-col>
        <el-table
          :key="tableKey"
          v-loading="listLoading"
          :data="list"
          border
          fit
          highlight-current-row
          :header-cell-style="{background:'#ebeef5'}"
          style="width: 100%;"
        >
          <el-table-column
            type="index"
            width="55"
            align="center"
            label="序号"
          />
          <el-table-column :label="$t('table.ref_no')" prop="ref_no" align="center" />
          <el-table-column label="出库单号" prop="order_no" align="center" />
          <el-table-column label="订单日期" align="center" prop="issue_date" sortable>
            <template slot-scope="{row}">
              <span>{{ row.issue_date | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
            </template>
          </el-table-column>
          <el-table-column label="状态" align="center" prop="issue_status">
            <template slot-scope="{row}">
              <el-tag :type="row.issue_status | statusFilter">
                {{ row.issue_status }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column label="订单数量" align="center" prop="order_qty" sortable />
          <el-table-column :label="$t('table.actions')" align="center" width="160" class-name="small-padding fixed-width">
            <template slot-scope="{row}">
              <router-link :to="{ name:'OutBoundCreateOrUpdate', params: createOrUpdateData }">
                <el-button v-if="row.issue_status == 'NEW' " type="primary" size="mini" @click="handleUpdate(row)">
                  {{ $t('table.edit') }}
                </el-button>
              </router-link>
              <el-button v-if="row.issue_status=='SHIPPED'" size="mini" type="danger" @click="handleDelete(row)">
                {{ $t('table.delete') }}
              </el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.page_limit" @pagination="getList" />
  </div>
</template>

<script>
import { queryList, queryDelete } from '@/api/outbound'
import waves from '@/directive/waves' // waves directive
// import { parseTime } from '@/utils'
import { getToken } from '@/utils/auth'
import { getInfo } from '@/api/user'
import Pagination from '@/components/Pagination' // secondary package based on el-pagination
// import UploadExcelComponent from '@/components/UploadExcel/custom.vue'
// import CreateOrUpdate from '@/views/order/inbound/components/CreateOrUpdate'
// import { warehouseList } from '@/api/common'

export default {
  name: 'OutBound',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        NEW: 'warning',
        RECEIPTING: 'success'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      loginUser: '',
      excelTemplateUrl: '',
      tableKey: 0,
      list: null,
      total: 0,
      pickerDate: null,
      listLoading: true,
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
      // 传递到子组件数据
      createOrUpdateData: {
        status: '',
        issue_id: null
      },
      temp: {
        customer_id: null,
        warehouse_code: null,
        booking_date: new Date(),
        order_qty: null,
        qty_case: null,
        ref_no: null,
        po_no: null,
        case_length: null,
        case_width: null,
        case_height: null,
        case_weight: null
      },
      textMap: {
        update: '编辑',
        create: '创建'
      }
    }
  },
  created() {
    this.getList()
    this.getLoginUser()
  },
  methods: {
    // 获取当前登录用户
    getLoginUser() {
      getInfo(getToken()).then(response => {
        this.loginUser = response.data
      })
    },
    // 获取入库数据
    getList() {
      this.listLoading = true
      queryList(this.listQuery).then(response => {
        this.list = response.data.data
        this.total = response.data.total

        // 关闭加载按钮
        this.listLoading = false
      })
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
    // 重置缓存
    resetTemp() {
      this.temp = {
        ref_no: null,
        warehouse_code: null,
        booing_date: new Date(),
        order_qty: null
      }
    },
    handleCreate() {
      this.createOrUpdateData.status = 'create'
    },
    handleUpdate(row) {
      this.createOrUpdateData.status = 'update'
      this.createOrUpdateData.issue_id = row.issue_id
    },
    // 删除
    handleDelete(row) {
      queryDelete(row).then(response => {
        if (response.code === 2001) {
          this.$message({
            message: '删除成功',
            type: 'success'
          })
          this.getList()
        } else {
          this.$message.error('删除失败')
        }
      })
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
  .detail-add-divider{
    display: inline-block;
  }
</style>
