import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\RekapitulasiController::showRekapitulasiView
* @see app/Http/Controllers/RekapitulasiController.php:14
* @route '/rekapitulasi'
*/
export const showRekapitulasiView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showRekapitulasiView.url(options),
    method: 'get',
})

showRekapitulasiView.definition = {
    methods: ["get","head"],
    url: '/rekapitulasi',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\RekapitulasiController::showRekapitulasiView
* @see app/Http/Controllers/RekapitulasiController.php:14
* @route '/rekapitulasi'
*/
showRekapitulasiView.url = (options?: RouteQueryOptions) => {
    return showRekapitulasiView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\RekapitulasiController::showRekapitulasiView
* @see app/Http/Controllers/RekapitulasiController.php:14
* @route '/rekapitulasi'
*/
showRekapitulasiView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showRekapitulasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\RekapitulasiController::showRekapitulasiView
* @see app/Http/Controllers/RekapitulasiController.php:14
* @route '/rekapitulasi'
*/
showRekapitulasiView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showRekapitulasiView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\RekapitulasiController::showRekapitulasiView
* @see app/Http/Controllers/RekapitulasiController.php:14
* @route '/rekapitulasi'
*/
const showRekapitulasiViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showRekapitulasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\RekapitulasiController::showRekapitulasiView
* @see app/Http/Controllers/RekapitulasiController.php:14
* @route '/rekapitulasi'
*/
showRekapitulasiViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showRekapitulasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\RekapitulasiController::showRekapitulasiView
* @see app/Http/Controllers/RekapitulasiController.php:14
* @route '/rekapitulasi'
*/
showRekapitulasiViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showRekapitulasiView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showRekapitulasiView.form = showRekapitulasiViewForm

const RekapitulasiController = { showRekapitulasiView }

export default RekapitulasiController