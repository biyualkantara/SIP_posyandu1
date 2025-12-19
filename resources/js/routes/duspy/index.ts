import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/api/duspy'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/duspy',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/api/duspy'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/api/duspy'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/api/duspy'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/api/duspy'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/api/duspy'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/api/duspy'
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
* @see \App\Http\Controllers\DuspyController::store
* @see app/Http/Controllers/DuspyController.php:0
* @route '/api/duspy'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/duspy',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DuspyController::store
* @see app/Http/Controllers/DuspyController.php:0
* @route '/api/duspy'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::store
* @see app/Http/Controllers/DuspyController.php:0
* @route '/api/duspy'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::store
* @see app/Http/Controllers/DuspyController.php:0
* @route '/api/duspy'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::store
* @see app/Http/Controllers/DuspyController.php:0
* @route '/api/duspy'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/api/duspy/{duspy}'
*/
export const show = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/duspy/{duspy}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/api/duspy/{duspy}'
*/
show.url = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { duspy: args }
    }

    if (Array.isArray(args)) {
        args = {
            duspy: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        duspy: args.duspy,
    }

    return show.definition.url
            .replace('{duspy}', parsedArgs.duspy.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/api/duspy/{duspy}'
*/
show.get = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/api/duspy/{duspy}'
*/
show.head = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/api/duspy/{duspy}'
*/
const showForm = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/api/duspy/{duspy}'
*/
showForm.get = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/api/duspy/{duspy}'
*/
showForm.head = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/api/duspy/{duspy}'
*/
export const update = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/duspy/{duspy}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/api/duspy/{duspy}'
*/
update.url = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { duspy: args }
    }

    if (Array.isArray(args)) {
        args = {
            duspy: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        duspy: args.duspy,
    }

    return update.definition.url
            .replace('{duspy}', parsedArgs.duspy.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/api/duspy/{duspy}'
*/
update.put = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/api/duspy/{duspy}'
*/
update.patch = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/api/duspy/{duspy}'
*/
const updateForm = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/api/duspy/{duspy}'
*/
updateForm.put = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/api/duspy/{duspy}'
*/
updateForm.patch = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/api/duspy/{duspy}'
*/
export const destroy = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/duspy/{duspy}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/api/duspy/{duspy}'
*/
destroy.url = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { duspy: args }
    }

    if (Array.isArray(args)) {
        args = {
            duspy: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        duspy: args.duspy,
    }

    return destroy.definition.url
            .replace('{duspy}', parsedArgs.duspy.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/api/duspy/{duspy}'
*/
destroy.delete = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/api/duspy/{duspy}'
*/
const destroyForm = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/api/duspy/{duspy}'
*/
destroyForm.delete = (args: { duspy: string | number } | [duspy: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const duspy = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default duspy