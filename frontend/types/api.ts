export type ApiItemsResponse<T> = {
    items: T[],
}

export type PaginatedApiResponse<T> = ApiItemsResponse<T> & {
    _pagination: {
        page: number,
        per_page: number,
        total_count: number,
        total_pages: number,
    }
}

export type ApiDecimal = {
    raw: number,
    formatted: string,
}