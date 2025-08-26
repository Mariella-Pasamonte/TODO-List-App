export interface TaskType{
    id: number
    name: string
    description?: string
    category?: string
    category_id: number
    isCompleted?: boolean
    dueDate?: Date
  }