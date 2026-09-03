import { axiosLib } from '../../lib'

export interface IProps {
  payload: {
    name: string
    email: string
    password: string
    password_confirmation: string
  }
}

export const postUser = async (props: IProps) => {
  return await axiosLib.instance
    .post('/users', props.payload)
    .then((res) => res)
    .catch((res) => axiosLib.throwAxios(res))
}
