import { axiosLib } from '../../lib'

export interface IProps {
  payload: {
    name: string
    email: string
    password?: string
    password_confirmation?: string
  }
}

export const putUser = async (id: number | string, props: IProps) => {
  return await axiosLib.instance
    .put(`/users/${id}`, props.payload)
    .then((res) => res)
    .catch((res) => axiosLib.throwAxios(res))
}
