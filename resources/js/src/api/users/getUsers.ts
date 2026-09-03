import { axiosLib } from '../../lib'

export interface User {
  id: number
  name: string
  email: string
  created_at: string
}

export interface IProps {
  query?: {
    search?: string
    page?: string
    limit?: string
  }
}

export const getUsers = async (props?: IProps) => {
  return await axiosLib.instance
    .get(`/users` + axiosLib.createQueryStr(props))
    .then((res) => res)
    .catch((res) => axiosLib.throwAxios(res))
}
