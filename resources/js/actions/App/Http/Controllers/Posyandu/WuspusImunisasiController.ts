import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::index
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:13
* @route '/posyandu/wuspus-imun'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/posyandu/wuspus-imun',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::index
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:13
* @route '/posyandu/wuspus-imun'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::index
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:13
* @route '/posyandu/wuspus-imun'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::index
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:13
* @route '/posyandu/wuspus-imun'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::index
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:13
* @route '/posyandu/wuspus-imun'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::index
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:13
* @route '/posyandu/wuspus-imun'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::index
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:13
* @route '/posyandu/wuspus-imun'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::create
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:97
* @route '/posyandu/wuspus-imun/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/posyandu/wuspus-imun/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::create
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:97
* @route '/posyandu/wuspus-imun/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::create
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:97
* @route '/posyandu/wuspus-imun/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::create
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:97
* @route '/posyandu/wuspus-imun/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::create
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:97
* @route '/posyandu/wuspus-imun/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::create
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:97
* @route '/posyandu/wuspus-imun/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::create
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:97
* @route '/posyandu/wuspus-imun/create'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:137
* @route '/posyandu/wuspus-imun/store-multiple'
*/
export const storeMultiple = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

storeMultiple.definition = {
    methods: ["post"],
    url: '/posyandu/wuspus-imun/store-multiple',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:137
* @route '/posyandu/wuspus-imun/store-multiple'
*/
storeMultiple.url = (options?: RouteQueryOptions) => {
    return storeMultiple.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:137
* @route '/posyandu/wuspus-imun/store-multiple'
*/
storeMultiple.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:137
* @route '/posyandu/wuspus-imun/store-multiple'
*/
const storeMultipleForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeMultiple.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::storeMultiple
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:137
* @route '/posyandu/wuspus-imun/store-multiple'
*/
storeMultipleForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeMultiple.url(options),
    method: 'post',
})

storeMultiple.form = storeMultipleForm

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::show
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:170
* @route '/posyandu/wuspus-imun/{id}'
*/
export const show = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/posyandu/wuspus-imun/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::show
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:170
* @route '/posyandu/wuspus-imun/{id}'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::show
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:170
* @route '/posyandu/wuspus-imun/{id}'
*/
show.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::show
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:170
* @route '/posyandu/wuspus-imun/{id}'
*/
show.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::show
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:170
* @route '/posyandu/wuspus-imun/{id}'
*/
const showForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::show
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:170
* @route '/posyandu/wuspus-imun/{id}'
*/
showForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::show
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:170
* @route '/posyandu/wuspus-imun/{id}'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::edit
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:195
* @route '/posyandu/wuspus-imun/{id}/edit'
*/
export const edit = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/posyandu/wuspus-imun/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::edit
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:195
* @route '/posyandu/wuspus-imun/{id}/edit'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::edit
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:195
* @route '/posyandu/wuspus-imun/{id}/edit'
*/
edit.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::edit
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:195
* @route '/posyandu/wuspus-imun/{id}/edit'
*/
edit.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::edit
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:195
* @route '/posyandu/wuspus-imun/{id}/edit'
*/
const editForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::edit
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:195
* @route '/posyandu/wuspus-imun/{id}/edit'
*/
editForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::edit
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:195
* @route '/posyandu/wuspus-imun/{id}/edit'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::update
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:216
* @route '/posyandu/wuspus-imun/{id}'
*/
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/posyandu/wuspus-imun/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::update
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:216
* @route '/posyandu/wuspus-imun/{id}'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::update
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:216
* @route '/posyandu/wuspus-imun/{id}'
*/
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::update
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:216
* @route '/posyandu/wuspus-imun/{id}'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::update
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:216
* @route '/posyandu/wuspus-imun/{id}'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:235
* @route '/posyandu/wuspus-imun/{id}'
*/
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/posyandu/wuspus-imun/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:235
* @route '/posyandu/wuspus-imun/{id}'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:235
* @route '/posyandu/wuspus-imun/{id}'
*/
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:235
* @route '/posyandu/wuspus-imun/{id}'
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
* @see \App\Http\Controllers\Posyandu\WuspusImunisasiController::destroy
* @see app/Http/Controllers/Posyandu/WuspusImunisasiController.php:235
* @route '/posyandu/wuspus-imun/{id}'
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

const WuspusImunisasiController = { index, create, storeMultiple, show, edit, update, destroy }

export default WuspusImunisasiController