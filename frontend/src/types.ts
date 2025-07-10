export type TUser = {
  user_id: string;
  first_name: string;
  last_name: string;
  email: string;
  password?: string;
}

export type TProducts = {
  product_id: number,
  name: string,
  category: string,
  price: number,
  stock: number,
  description: string,
  image: string
}

export type TAddToCart = TProducts & {
  user_id: string,
  quantity: number
}
export type TCartItem = TProducts & {
  quantity: number
}