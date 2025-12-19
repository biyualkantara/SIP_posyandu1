import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::index
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:13
* @route '/posyandu/wuspus-kontrasepsi'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/posyandu/wuspus-kontrasepsi',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::index
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:13
* @route '/posyandu/wuspus-kontrasepsi'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::index
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:13
* @route '/posyandu/wuspus-kontrasepsi'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::index
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:13
* @route '/posyandu/wuspus-kontrasepsi'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::index
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:13
* @route '/posyandu/wuspus-kontrasepsi'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::index
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:13
* @route '/posyandu/wuspus-kontrasepsi'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::index
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:13
* @route '/posyandu/wuspus-kontrasepsi'
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
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::create
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:84
* @route '/posyandu/wuspus-kontrasepsi/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/posyandu/wuspus-kontrasepsi/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::create
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:84
* @route '/posyandu/wuspus-kontrasepsi/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::create
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:84
* @route '/posyandu/wuspus-kontrasepsi/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::create
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:84
* @route '/posyandu/wuspus-kontrasepsi/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::create
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:84
* @route '/posyandu/wuspus-kontrasepsi/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::create
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:84
* @route '/posyandu/wuspus-kontrasepsi/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::create
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:84
* @route '/posyandu/wuspus-kontrasepsi/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:114
* @route '/posyandu/wuspus-kontrasepsi/store-multiple'
*/
export const storeMultiple = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

storeMultiple.definition = {
    methods: ["post"],
    url: '/posyandu/wuspus-kontrasepsi/store-multiple',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:114
* @route '/posyandu/wuspus-kontrasepsi/store-multiple'
*/
storeMultiple.url = (options?: RouteQueryOptions) => {
    return storeMultiple.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:114
* @route '/posyandu/wuspus-kontrasepsi/store-multiple'
*/
storeMultiple.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:114
* @route '/posyandu/wuspus-kontrasepsi/store-multiple'
*/
const storeMultipleForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeMultiple.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:114
* @route '/posyandu/wuspus-kontrasepsi/store-multiple'
*/
storeMultipleForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeMultiple.url(options),
    method: 'post',
})

storeMultiple.form = storeMultipleForm

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::show
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:143
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
export const show = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/posyandu/wuspus-kontrasepsi/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::show
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:143
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
show.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return show.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::show
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:143
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
show.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::show
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:143
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
show.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::show
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:143
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
const showForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::show
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:143
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
showForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::show
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:143
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
showForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::edit
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:166
* @route '/posyandu/wuspus-kontrasepsi/{id}/edit'
*/
export const edit = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/posyandu/wuspus-kontrasepsi/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::edit
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:166
* @route '/posyandu/wuspus-kontrasepsi/{id}/edit'
*/
edit.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return edit.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::edit
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:166
* @route '/posyandu/wuspus-kontrasepsi/{id}/edit'
*/
edit.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::edit
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:166
* @route '/posyandu/wuspus-kontrasepsi/{id}/edit'
*/
edit.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::edit
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:166
* @route '/posyandu/wuspus-kontrasepsi/{id}/edit'
*/
const editForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::edit
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:166
* @route '/posyandu/wuspus-kontrasepsi/{id}/edit'
*/
editForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::edit
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:166
* @route '/posyandu/wuspus-kontrasepsi/{id}/edit'
*/
editForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::update
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:181
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/posyandu/wuspus-kontrasepsi/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::update
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:181
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
update.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return update.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::update
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:181
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::update
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:181
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
const updateForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::update
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:181
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
updateForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:203
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/posyandu/wuspus-kontrasepsi/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:203
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
destroy.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return destroy.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:203
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:203
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
const destroyForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusKontrasepsiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusKontrasepsiController.php:203
* @route '/posyandu/wuspus-kontrasepsi/{id}'
*/
destroyForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const WuspusKontrasepsiController = { index, create, storeMultiple, show, edit, update, destroy }

export default WuspusKontrasepsiController