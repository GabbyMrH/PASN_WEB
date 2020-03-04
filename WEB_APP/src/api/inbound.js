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

// 预约入库
export function queryInboundAdd(query) {
  return request({
    url: 'inbound/add',
    method: 'post',
    params: query
  })
}
