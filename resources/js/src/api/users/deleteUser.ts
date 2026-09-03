import { axiosLib } from '../../lib'

export interface IProps {
  params: {
    user_id: number | string
  }
}

export const deleteUser = async (props: IProps) => {
  return await axiosLib.instance
    .delete(`/users/${props.params.user_id}`)
    .then((res) => res)
    .catch((res) => axiosLib.throwAxios(res))
}
