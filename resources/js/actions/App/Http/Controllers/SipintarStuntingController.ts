import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\SipintarStuntingController::index
 * @see app/Http/Controllers/SipintarStuntingController.php:10
 * @route '/sipintar/stunting'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/sipintar/stunting',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SipintarStuntingController::index
 * @see app/Http/Controllers/SipintarStuntingController.php:10
 * @route '/sipintar/stunting'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarStuntingController::index
 * @see app/Http/Controllers/SipintarStuntingController.php:10
 * @route '/sipintar/stunting'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\SipintarStuntingController::index
 * @see app/Http/Controllers/SipintarStuntingController.php:10
 * @route '/sipintar/stunting'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\SipintarStuntingController::index
 * @see app/Http/Controllers/SipintarStuntingController.php:10
 * @route '/sipintar/stunting'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\SipintarStuntingController::index
 * @see app/Http/Controllers/SipintarStuntingController.php:10
 * @route '/sipintar/stunting'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\SipintarStuntingController::index
 * @see app/Http/Controllers/SipintarStuntingController.php:10
 * @route '/sipintar/stunting'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
const SipintarStuntingController = { index }

export default SipintarStuntingController