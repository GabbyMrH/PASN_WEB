import request from '@/utils/request'

// 列表
export function tableList(query) {
  return request({
    url: 'inbound',
    method: 'get',
    params: query
  })
}

// 详情列表
export function detailList(query) {
  return request({
    url: 'inbound/detail',
    method: 'get',
    params: query
  })
}

// 添加预约入库单
export function queryInBoundAdd(query) {
  return request({
    url: 'inbound/add',
    method: 'post',
    params: query
  })
}

// 删除入库单
export function queryInBoundDelete(query) {
  return request({
    url: 'inbound/delete',
    method: 'delete',
    params: query
  })
}

// 编辑入库详情单
export function queryInBoundDetailEdit(query) {
  return request({
    url: 'inbound/detail',
    method: 'put',
    params: query
  })
}

// 删除入库详情单
export function queryInBoundDetailDelete(query) {
  return request({
    url: 'inbound/detail',
    method: 'delete',
    params: query
  })
}
