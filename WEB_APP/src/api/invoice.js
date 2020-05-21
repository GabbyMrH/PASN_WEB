import request from '@/utils/request'

// 列表数据
export function queryList(query) {
  return request({
    url: 'invoice',
    method: 'get',
    params: query
  })
}

// 改变状态
export function queryChangeStatus(query) {
  return request({
    url: 'invoice',
    method: 'put',
    params: query
  })
}
