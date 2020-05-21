import request from '@/utils/request'

// 列表数据
export function queryList(query) {
  return request({
    url: 'outbound',
    method: 'get',
    params: query
  })
}

// 从表详情列表
export function queryDetailList(query) {
  return request({
    url: 'outbound/detail',
    method: 'get',
    params: query
  })
}

// 写入数据
export function queryInsert(query) {
  return request({
    url: 'outbound',
    method: 'post',
    params: query
  })
}

// 编辑数据
export function queryDetailEdit(query) {
  return request({
    url: 'outbound/detail',
    method: 'put',
    params: query
  })
}

// 删除主数据
export function queryDelete(query) {
  return request({
    url: 'outbound',
    method: 'delete',
    params: query
  })
}

// 删除details
export function queryDeleteDetaill(query) {
  return request({
    url: 'outbound/detail',
    method: 'delete',
    params: query
  })
}
