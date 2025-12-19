import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
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

/**
* @see \App\Http\Controllers\SipintarStuntingController::analisis
* @see app/Http/Controllers/SipintarStuntingController.php:0
* @route '/sipintar/stunting/analisis/{id_bayi}'
*/
export const analisis = (args: { id_bayi: string | number } | [id_bayi: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: analisis.url(args, options),
    method: 'post',
})

analisis.definition = {
    methods: ["post"],
    url: '/sipintar/stunting/analisis/{id_bayi}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\SipintarStuntingController::analisis
* @see app/Http/Controllers/SipintarStuntingController.php:0
* @route '/sipintar/stunting/analisis/{id_bayi}'
*/
analisis.url = (args: { id_bayi: string | number } | [id_bayi: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id_bayi: args }
    }

    if (Array.isArray(args)) {
        args = {
            id_bayi: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id_bayi: args.id_bayi,
    }

    return analisis.definition.url
            .replace('{id_bayi}', parsedArgs.id_bayi.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\SipintarStuntingController::analisis
* @see app/Http/Controllers/SipintarStuntingController.php:0
* @route '/sipintar/stunting/analisis/{id_bayi}'
*/
analisis.post = (args: { id_bayi: string | number } | [id_bayi: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: analisis.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SipintarStuntingController::analisis
* @see app/Http/Controllers/SipintarStuntingController.php:0
* @route '/sipintar/stunting/analisis/{id_bayi}'
*/
const analisisForm = (args: { id_bayi: string | number } | [id_bayi: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: analisis.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SipintarStuntingController::analisis
* @see app/Http/Controllers/SipintarStuntingController.php:0
* @route '/sipintar/stunting/analisis/{id_bayi}'
*/
analisisForm.post = (args: { id_bayi: string | number } | [id_bayi: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: analisis.url(args, options),
    method: 'post',
})

analisis.form = analisisForm

const SipintarStuntingController = { index, analisis }

export default SipintarStuntingController