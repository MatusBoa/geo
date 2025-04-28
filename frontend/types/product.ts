import type { ApiDecimal } from "~/types/api"

export type Product = {
    id: number,
    name: string,
    price: ApiDecimal,
    created_at: string,
    updated_at: string,
}