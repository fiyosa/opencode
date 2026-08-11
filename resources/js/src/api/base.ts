export interface IRes<T> {
  data: T
  message?: string
}

export interface IError {
  message: string
  errors?: Record<string, string[]>
}

export interface IMeta {
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number | null
  to: number | null
}

export interface IResPaginate<T> {
  data: T[]
  meta: IMeta
}
