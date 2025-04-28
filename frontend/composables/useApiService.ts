export default function useApiService() {
    return new ApiService()
}

class ApiService<T> {
    async get<T>(uri: string): Promise<T> {
        return $fetch(this.apiUrl(uri))
    }

    private apiUrl(uri: string) {
        return `${useRuntimeConfig().public.apiBase}${uri.padStart(1, '/')}`
    }
}