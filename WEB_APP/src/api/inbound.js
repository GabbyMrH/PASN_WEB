import request from '@/utils/request'

// 列表
export function tableList(query) {
  return request({
    url: 'inbound',
    method: 'get',
    params: query
  })
}

// 弹出框列表
export function dialogList(query) {
  return request({
    url: 'inbound/detail',
    method: 'get',
    params: query
  })
}
