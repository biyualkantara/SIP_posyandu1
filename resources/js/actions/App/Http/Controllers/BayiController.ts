import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\BayiController::showBiodataView
* @see app/Http/Controllers/BayiController.php:19
* @route '/data_bayi/biodata'
*/
export const showBiodataView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showBiodataView.url(options),
    method: 'get',
})

showBiodataView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/biodata',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showBiodataView
* @see app/Http/Controllers/BayiController.php:19
* @route '/data_bayi/biodata'
*/
showBiodataView.url = (options?: RouteQueryOptions) => {
    return showBiodataView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showBiodataView
* @see app/Http/Controllers/BayiController.php:19
* @route '/data_bayi/biodata'
*/
showBiodataView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showBiodataView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showBiodataView
* @see app/Http/Controllers/BayiController.php:19
* @route '/data_bayi/biodata'
*/
showBiodataView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showBiodataView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showBiodataView
* @see app/Http/Controllers/BayiController.php:19
* @route '/data_bayi/biodata'
*/
const showBiodataViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showBiodataView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showBiodataView
* @see app/Http/Controllers/BayiController.php:19
* @route '/data_bayi/biodata'
*/
showBiodataViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showBiodataView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showBiodataView
* @see app/Http/Controllers/BayiController.php:19
* @route '/data_bayi/biodata'
*/
showBiodataViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showBiodataView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showBiodataView.form = showBiodataViewForm

/**
* @see \App\Http\Controllers\BayiController::showAddBiodataView
* @see app/Http/Controllers/BayiController.php:29
* @route '/data_bayi/biodata/add'
*/
export const showAddBiodataView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showAddBiodataView.url(options),
    method: 'get',
})

showAddBiodataView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/biodata/add',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showAddBiodataView
* @see app/Http/Controllers/BayiController.php:29
* @route '/data_bayi/biodata/add'
*/
showAddBiodataView.url = (options?: RouteQueryOptions) => {
    return showAddBiodataView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showAddBiodataView
* @see app/Http/Controllers/BayiController.php:29
* @route '/data_bayi/biodata/add'
*/
showAddBiodataView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showAddBiodataView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddBiodataView
* @see app/Http/Controllers/BayiController.php:29
* @route '/data_bayi/biodata/add'
*/
showAddBiodataView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showAddBiodataView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showAddBiodataView
* @see app/Http/Controllers/BayiController.php:29
* @route '/data_bayi/biodata/add'
*/
const showAddBiodataViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddBiodataView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddBiodataView
* @see app/Http/Controllers/BayiController.php:29
* @route '/data_bayi/biodata/add'
*/
showAddBiodataViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddBiodataView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddBiodataView
* @see app/Http/Controllers/BayiController.php:29
* @route '/data_bayi/biodata/add'
*/
showAddBiodataViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddBiodataView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showAddBiodataView.form = showAddBiodataViewForm

/**
* @see \App\Http\Controllers\BayiController::handlePostBiodata
* @see app/Http/Controllers/BayiController.php:38
* @route '/data_bayi/biodata'
*/
export const handlePostBiodata = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handlePostBiodata.url(options),
    method: 'post',
})

handlePostBiodata.definition = {
    methods: ["post"],
    url: '/data_bayi/biodata',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\BayiController::handlePostBiodata
* @see app/Http/Controllers/BayiController.php:38
* @route '/data_bayi/biodata'
*/
handlePostBiodata.url = (options?: RouteQueryOptions) => {
    return handlePostBiodata.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handlePostBiodata
* @see app/Http/Controllers/BayiController.php:38
* @route '/data_bayi/biodata'
*/
handlePostBiodata.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handlePostBiodata.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handlePostBiodata
* @see app/Http/Controllers/BayiController.php:38
* @route '/data_bayi/biodata'
*/
const handlePostBiodataForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handlePostBiodata.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handlePostBiodata
* @see app/Http/Controllers/BayiController.php:38
* @route '/data_bayi/biodata'
*/
handlePostBiodataForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handlePostBiodata.url(options),
    method: 'post',
})

handlePostBiodata.form = handlePostBiodataForm

/**
* @see \App\Http\Controllers\BayiController::showEditBiodataView
* @see app/Http/Controllers/BayiController.php:83
* @route '/data_bayi/biodata/{id}/edit'
*/
export const showEditBiodataView = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showEditBiodataView.url(args, options),
    method: 'get',
})

showEditBiodataView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/biodata/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showEditBiodataView
* @see app/Http/Controllers/BayiController.php:83
* @route '/data_bayi/biodata/{id}/edit'
*/
showEditBiodataView.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return showEditBiodataView.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showEditBiodataView
* @see app/Http/Controllers/BayiController.php:83
* @route '/data_bayi/biodata/{id}/edit'
*/
showEditBiodataView.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showEditBiodataView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditBiodataView
* @see app/Http/Controllers/BayiController.php:83
* @route '/data_bayi/biodata/{id}/edit'
*/
showEditBiodataView.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showEditBiodataView.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showEditBiodataView
* @see app/Http/Controllers/BayiController.php:83
* @route '/data_bayi/biodata/{id}/edit'
*/
const showEditBiodataViewForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditBiodataView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditBiodataView
* @see app/Http/Controllers/BayiController.php:83
* @route '/data_bayi/biodata/{id}/edit'
*/
showEditBiodataViewForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditBiodataView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditBiodataView
* @see app/Http/Controllers/BayiController.php:83
* @route '/data_bayi/biodata/{id}/edit'
*/
showEditBiodataViewForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditBiodataView.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showEditBiodataView.form = showEditBiodataViewForm

/**
* @see \App\Http\Controllers\BayiController::handleUpdateBiodata
* @see app/Http/Controllers/BayiController.php:91
* @route '/data_bayi/biodata/{id}'
*/
export const handleUpdateBiodata = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: handleUpdateBiodata.url(args, options),
    method: 'put',
})

handleUpdateBiodata.definition = {
    methods: ["put"],
    url: '/data_bayi/biodata/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\BayiController::handleUpdateBiodata
* @see app/Http/Controllers/BayiController.php:91
* @route '/data_bayi/biodata/{id}'
*/
handleUpdateBiodata.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return handleUpdateBiodata.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handleUpdateBiodata
* @see app/Http/Controllers/BayiController.php:91
* @route '/data_bayi/biodata/{id}'
*/
handleUpdateBiodata.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: handleUpdateBiodata.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\BayiController::handleUpdateBiodata
* @see app/Http/Controllers/BayiController.php:91
* @route '/data_bayi/biodata/{id}'
*/
const handleUpdateBiodataForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleUpdateBiodata.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handleUpdateBiodata
* @see app/Http/Controllers/BayiController.php:91
* @route '/data_bayi/biodata/{id}'
*/
handleUpdateBiodataForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleUpdateBiodata.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

handleUpdateBiodata.form = handleUpdateBiodataForm

/**
* @see \App\Http\Controllers\BayiController::handleDeleteBiodata
* @see app/Http/Controllers/BayiController.php:125
* @route '/data_bayi/biodata/{id}'
*/
export const handleDeleteBiodata = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: handleDeleteBiodata.url(args, options),
    method: 'delete',
})

handleDeleteBiodata.definition = {
    methods: ["delete"],
    url: '/data_bayi/biodata/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\BayiController::handleDeleteBiodata
* @see app/Http/Controllers/BayiController.php:125
* @route '/data_bayi/biodata/{id}'
*/
handleDeleteBiodata.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return handleDeleteBiodata.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handleDeleteBiodata
* @see app/Http/Controllers/BayiController.php:125
* @route '/data_bayi/biodata/{id}'
*/
handleDeleteBiodata.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: handleDeleteBiodata.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\BayiController::handleDeleteBiodata
* @see app/Http/Controllers/BayiController.php:125
* @route '/data_bayi/biodata/{id}'
*/
const handleDeleteBiodataForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleDeleteBiodata.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handleDeleteBiodata
* @see app/Http/Controllers/BayiController.php:125
* @route '/data_bayi/biodata/{id}'
*/
handleDeleteBiodataForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleDeleteBiodata.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

handleDeleteBiodata.form = handleDeleteBiodataForm

/**
* @see \App\Http\Controllers\BayiController::showPenimbanganView
* @see app/Http/Controllers/BayiController.php:141
* @route '/data_bayi/penimbangan'
*/
export const showPenimbanganView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showPenimbanganView.url(options),
    method: 'get',
})

showPenimbanganView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/penimbangan',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showPenimbanganView
* @see app/Http/Controllers/BayiController.php:141
* @route '/data_bayi/penimbangan'
*/
showPenimbanganView.url = (options?: RouteQueryOptions) => {
    return showPenimbanganView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showPenimbanganView
* @see app/Http/Controllers/BayiController.php:141
* @route '/data_bayi/penimbangan'
*/
showPenimbanganView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showPenimbanganView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showPenimbanganView
* @see app/Http/Controllers/BayiController.php:141
* @route '/data_bayi/penimbangan'
*/
showPenimbanganView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showPenimbanganView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showPenimbanganView
* @see app/Http/Controllers/BayiController.php:141
* @route '/data_bayi/penimbangan'
*/
const showPenimbanganViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showPenimbanganView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showPenimbanganView
* @see app/Http/Controllers/BayiController.php:141
* @route '/data_bayi/penimbangan'
*/
showPenimbanganViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showPenimbanganView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showPenimbanganView
* @see app/Http/Controllers/BayiController.php:141
* @route '/data_bayi/penimbangan'
*/
showPenimbanganViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showPenimbanganView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showPenimbanganView.form = showPenimbanganViewForm

/**
* @see \App\Http\Controllers\BayiController::showAddPenimbanganView
* @see app/Http/Controllers/BayiController.php:162
* @route '/data_bayi/penimbangan/tambah'
*/
export const showAddPenimbanganView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showAddPenimbanganView.url(options),
    method: 'get',
})

showAddPenimbanganView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/penimbangan/tambah',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showAddPenimbanganView
* @see app/Http/Controllers/BayiController.php:162
* @route '/data_bayi/penimbangan/tambah'
*/
showAddPenimbanganView.url = (options?: RouteQueryOptions) => {
    return showAddPenimbanganView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showAddPenimbanganView
* @see app/Http/Controllers/BayiController.php:162
* @route '/data_bayi/penimbangan/tambah'
*/
showAddPenimbanganView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showAddPenimbanganView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddPenimbanganView
* @see app/Http/Controllers/BayiController.php:162
* @route '/data_bayi/penimbangan/tambah'
*/
showAddPenimbanganView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showAddPenimbanganView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showAddPenimbanganView
* @see app/Http/Controllers/BayiController.php:162
* @route '/data_bayi/penimbangan/tambah'
*/
const showAddPenimbanganViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddPenimbanganView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddPenimbanganView
* @see app/Http/Controllers/BayiController.php:162
* @route '/data_bayi/penimbangan/tambah'
*/
showAddPenimbanganViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddPenimbanganView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddPenimbanganView
* @see app/Http/Controllers/BayiController.php:162
* @route '/data_bayi/penimbangan/tambah'
*/
showAddPenimbanganViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddPenimbanganView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showAddPenimbanganView.form = showAddPenimbanganViewForm

/**
* @see \App\Http\Controllers\BayiController::handlePostPenimbangan
* @see app/Http/Controllers/BayiController.php:172
* @route '/data_bayi/penimbangan'
*/
export const handlePostPenimbangan = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handlePostPenimbangan.url(options),
    method: 'post',
})

handlePostPenimbangan.definition = {
    methods: ["post"],
    url: '/data_bayi/penimbangan',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\BayiController::handlePostPenimbangan
* @see app/Http/Controllers/BayiController.php:172
* @route '/data_bayi/penimbangan'
*/
handlePostPenimbangan.url = (options?: RouteQueryOptions) => {
    return handlePostPenimbangan.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handlePostPenimbangan
* @see app/Http/Controllers/BayiController.php:172
* @route '/data_bayi/penimbangan'
*/
handlePostPenimbangan.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handlePostPenimbangan.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handlePostPenimbangan
* @see app/Http/Controllers/BayiController.php:172
* @route '/data_bayi/penimbangan'
*/
const handlePostPenimbanganForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handlePostPenimbangan.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handlePostPenimbangan
* @see app/Http/Controllers/BayiController.php:172
* @route '/data_bayi/penimbangan'
*/
handlePostPenimbanganForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handlePostPenimbangan.url(options),
    method: 'post',
})

handlePostPenimbangan.form = handlePostPenimbanganForm

/**
* @see \App\Http\Controllers\BayiController::showEditPenimbanganView
* @see app/Http/Controllers/BayiController.php:208
* @route '/data_bayi/penimbangan/{id}/edit'
*/
export const showEditPenimbanganView = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showEditPenimbanganView.url(args, options),
    method: 'get',
})

showEditPenimbanganView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/penimbangan/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showEditPenimbanganView
* @see app/Http/Controllers/BayiController.php:208
* @route '/data_bayi/penimbangan/{id}/edit'
*/
showEditPenimbanganView.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return showEditPenimbanganView.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showEditPenimbanganView
* @see app/Http/Controllers/BayiController.php:208
* @route '/data_bayi/penimbangan/{id}/edit'
*/
showEditPenimbanganView.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showEditPenimbanganView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditPenimbanganView
* @see app/Http/Controllers/BayiController.php:208
* @route '/data_bayi/penimbangan/{id}/edit'
*/
showEditPenimbanganView.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showEditPenimbanganView.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showEditPenimbanganView
* @see app/Http/Controllers/BayiController.php:208
* @route '/data_bayi/penimbangan/{id}/edit'
*/
const showEditPenimbanganViewForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditPenimbanganView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditPenimbanganView
* @see app/Http/Controllers/BayiController.php:208
* @route '/data_bayi/penimbangan/{id}/edit'
*/
showEditPenimbanganViewForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditPenimbanganView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditPenimbanganView
* @see app/Http/Controllers/BayiController.php:208
* @route '/data_bayi/penimbangan/{id}/edit'
*/
showEditPenimbanganViewForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditPenimbanganView.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showEditPenimbanganView.form = showEditPenimbanganViewForm

/**
* @see \App\Http\Controllers\BayiController::handleUpdatePenimbangan
* @see app/Http/Controllers/BayiController.php:217
* @route '/data_bayi/penimbangan/{id}'
*/
export const handleUpdatePenimbangan = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: handleUpdatePenimbangan.url(args, options),
    method: 'put',
})

handleUpdatePenimbangan.definition = {
    methods: ["put"],
    url: '/data_bayi/penimbangan/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\BayiController::handleUpdatePenimbangan
* @see app/Http/Controllers/BayiController.php:217
* @route '/data_bayi/penimbangan/{id}'
*/
handleUpdatePenimbangan.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return handleUpdatePenimbangan.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handleUpdatePenimbangan
* @see app/Http/Controllers/BayiController.php:217
* @route '/data_bayi/penimbangan/{id}'
*/
handleUpdatePenimbangan.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: handleUpdatePenimbangan.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\BayiController::handleUpdatePenimbangan
* @see app/Http/Controllers/BayiController.php:217
* @route '/data_bayi/penimbangan/{id}'
*/
const handleUpdatePenimbanganForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleUpdatePenimbangan.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handleUpdatePenimbangan
* @see app/Http/Controllers/BayiController.php:217
* @route '/data_bayi/penimbangan/{id}'
*/
handleUpdatePenimbanganForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleUpdatePenimbangan.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

handleUpdatePenimbangan.form = handleUpdatePenimbanganForm

/**
* @see \App\Http\Controllers\BayiController::handleDeletePenimbangan
* @see app/Http/Controllers/BayiController.php:242
* @route '/data_bayi/penimbangan/{id}'
*/
export const handleDeletePenimbangan = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: handleDeletePenimbangan.url(args, options),
    method: 'delete',
})

handleDeletePenimbangan.definition = {
    methods: ["delete"],
    url: '/data_bayi/penimbangan/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\BayiController::handleDeletePenimbangan
* @see app/Http/Controllers/BayiController.php:242
* @route '/data_bayi/penimbangan/{id}'
*/
handleDeletePenimbangan.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return handleDeletePenimbangan.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handleDeletePenimbangan
* @see app/Http/Controllers/BayiController.php:242
* @route '/data_bayi/penimbangan/{id}'
*/
handleDeletePenimbangan.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: handleDeletePenimbangan.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\BayiController::handleDeletePenimbangan
* @see app/Http/Controllers/BayiController.php:242
* @route '/data_bayi/penimbangan/{id}'
*/
const handleDeletePenimbanganForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleDeletePenimbangan.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handleDeletePenimbangan
* @see app/Http/Controllers/BayiController.php:242
* @route '/data_bayi/penimbangan/{id}'
*/
handleDeletePenimbanganForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleDeletePenimbangan.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

handleDeletePenimbangan.form = handleDeletePenimbanganForm

/**
* @see \App\Http\Controllers\BayiController::showImunisasiView
* @see app/Http/Controllers/BayiController.php:252
* @route '/data_bayi/imunisasi'
*/
export const showImunisasiView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showImunisasiView.url(options),
    method: 'get',
})

showImunisasiView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/imunisasi',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showImunisasiView
* @see app/Http/Controllers/BayiController.php:252
* @route '/data_bayi/imunisasi'
*/
showImunisasiView.url = (options?: RouteQueryOptions) => {
    return showImunisasiView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showImunisasiView
* @see app/Http/Controllers/BayiController.php:252
* @route '/data_bayi/imunisasi'
*/
showImunisasiView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showImunisasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showImunisasiView
* @see app/Http/Controllers/BayiController.php:252
* @route '/data_bayi/imunisasi'
*/
showImunisasiView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showImunisasiView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showImunisasiView
* @see app/Http/Controllers/BayiController.php:252
* @route '/data_bayi/imunisasi'
*/
const showImunisasiViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showImunisasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showImunisasiView
* @see app/Http/Controllers/BayiController.php:252
* @route '/data_bayi/imunisasi'
*/
showImunisasiViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showImunisasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showImunisasiView
* @see app/Http/Controllers/BayiController.php:252
* @route '/data_bayi/imunisasi'
*/
showImunisasiViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showImunisasiView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showImunisasiView.form = showImunisasiViewForm

/**
* @see \App\Http\Controllers\BayiController::showAddImunisasiView
* @see app/Http/Controllers/BayiController.php:270
* @route '/data_bayi/imunisasi/tambah'
*/
export const showAddImunisasiView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showAddImunisasiView.url(options),
    method: 'get',
})

showAddImunisasiView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/imunisasi/tambah',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showAddImunisasiView
* @see app/Http/Controllers/BayiController.php:270
* @route '/data_bayi/imunisasi/tambah'
*/
showAddImunisasiView.url = (options?: RouteQueryOptions) => {
    return showAddImunisasiView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showAddImunisasiView
* @see app/Http/Controllers/BayiController.php:270
* @route '/data_bayi/imunisasi/tambah'
*/
showAddImunisasiView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showAddImunisasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddImunisasiView
* @see app/Http/Controllers/BayiController.php:270
* @route '/data_bayi/imunisasi/tambah'
*/
showAddImunisasiView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showAddImunisasiView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showAddImunisasiView
* @see app/Http/Controllers/BayiController.php:270
* @route '/data_bayi/imunisasi/tambah'
*/
const showAddImunisasiViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddImunisasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddImunisasiView
* @see app/Http/Controllers/BayiController.php:270
* @route '/data_bayi/imunisasi/tambah'
*/
showAddImunisasiViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddImunisasiView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddImunisasiView
* @see app/Http/Controllers/BayiController.php:270
* @route '/data_bayi/imunisasi/tambah'
*/
showAddImunisasiViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddImunisasiView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showAddImunisasiView.form = showAddImunisasiViewForm

/**
* @see \App\Http\Controllers\BayiController::handlePostImunisasi
* @see app/Http/Controllers/BayiController.php:281
* @route '/data_bayi/imunisasi'
*/
export const handlePostImunisasi = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handlePostImunisasi.url(options),
    method: 'post',
})

handlePostImunisasi.definition = {
    methods: ["post"],
    url: '/data_bayi/imunisasi',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\BayiController::handlePostImunisasi
* @see app/Http/Controllers/BayiController.php:281
* @route '/data_bayi/imunisasi'
*/
handlePostImunisasi.url = (options?: RouteQueryOptions) => {
    return handlePostImunisasi.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handlePostImunisasi
* @see app/Http/Controllers/BayiController.php:281
* @route '/data_bayi/imunisasi'
*/
handlePostImunisasi.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handlePostImunisasi.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handlePostImunisasi
* @see app/Http/Controllers/BayiController.php:281
* @route '/data_bayi/imunisasi'
*/
const handlePostImunisasiForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handlePostImunisasi.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handlePostImunisasi
* @see app/Http/Controllers/BayiController.php:281
* @route '/data_bayi/imunisasi'
*/
handlePostImunisasiForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handlePostImunisasi.url(options),
    method: 'post',
})

handlePostImunisasi.form = handlePostImunisasiForm

/**
* @see \App\Http\Controllers\BayiController::showEditImunisasiView
* @see app/Http/Controllers/BayiController.php:307
* @route '/data_bayi/imunisasi/{id}/edit'
*/
export const showEditImunisasiView = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showEditImunisasiView.url(args, options),
    method: 'get',
})

showEditImunisasiView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/imunisasi/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showEditImunisasiView
* @see app/Http/Controllers/BayiController.php:307
* @route '/data_bayi/imunisasi/{id}/edit'
*/
showEditImunisasiView.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return showEditImunisasiView.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showEditImunisasiView
* @see app/Http/Controllers/BayiController.php:307
* @route '/data_bayi/imunisasi/{id}/edit'
*/
showEditImunisasiView.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showEditImunisasiView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditImunisasiView
* @see app/Http/Controllers/BayiController.php:307
* @route '/data_bayi/imunisasi/{id}/edit'
*/
showEditImunisasiView.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showEditImunisasiView.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showEditImunisasiView
* @see app/Http/Controllers/BayiController.php:307
* @route '/data_bayi/imunisasi/{id}/edit'
*/
const showEditImunisasiViewForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditImunisasiView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditImunisasiView
* @see app/Http/Controllers/BayiController.php:307
* @route '/data_bayi/imunisasi/{id}/edit'
*/
showEditImunisasiViewForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditImunisasiView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditImunisasiView
* @see app/Http/Controllers/BayiController.php:307
* @route '/data_bayi/imunisasi/{id}/edit'
*/
showEditImunisasiViewForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditImunisasiView.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showEditImunisasiView.form = showEditImunisasiViewForm

/**
* @see \App\Http\Controllers\BayiController::handleUpdateImunisasi
* @see app/Http/Controllers/BayiController.php:317
* @route '/data_bayi/imunisasi/{id}'
*/
export const handleUpdateImunisasi = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: handleUpdateImunisasi.url(args, options),
    method: 'put',
})

handleUpdateImunisasi.definition = {
    methods: ["put"],
    url: '/data_bayi/imunisasi/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\BayiController::handleUpdateImunisasi
* @see app/Http/Controllers/BayiController.php:317
* @route '/data_bayi/imunisasi/{id}'
*/
handleUpdateImunisasi.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return handleUpdateImunisasi.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handleUpdateImunisasi
* @see app/Http/Controllers/BayiController.php:317
* @route '/data_bayi/imunisasi/{id}'
*/
handleUpdateImunisasi.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: handleUpdateImunisasi.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\BayiController::handleUpdateImunisasi
* @see app/Http/Controllers/BayiController.php:317
* @route '/data_bayi/imunisasi/{id}'
*/
const handleUpdateImunisasiForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleUpdateImunisasi.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handleUpdateImunisasi
* @see app/Http/Controllers/BayiController.php:317
* @route '/data_bayi/imunisasi/{id}'
*/
handleUpdateImunisasiForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleUpdateImunisasi.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

handleUpdateImunisasi.form = handleUpdateImunisasiForm

/**
* @see \App\Http\Controllers\BayiController::handleDeleteImunisasi
* @see app/Http/Controllers/BayiController.php:336
* @route '/data_bayi/imunisasi/{id}'
*/
export const handleDeleteImunisasi = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: handleDeleteImunisasi.url(args, options),
    method: 'delete',
})

handleDeleteImunisasi.definition = {
    methods: ["delete"],
    url: '/data_bayi/imunisasi/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\BayiController::handleDeleteImunisasi
* @see app/Http/Controllers/BayiController.php:336
* @route '/data_bayi/imunisasi/{id}'
*/
handleDeleteImunisasi.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return handleDeleteImunisasi.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handleDeleteImunisasi
* @see app/Http/Controllers/BayiController.php:336
* @route '/data_bayi/imunisasi/{id}'
*/
handleDeleteImunisasi.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: handleDeleteImunisasi.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\BayiController::handleDeleteImunisasi
* @see app/Http/Controllers/BayiController.php:336
* @route '/data_bayi/imunisasi/{id}'
*/
const handleDeleteImunisasiForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleDeleteImunisasi.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handleDeleteImunisasi
* @see app/Http/Controllers/BayiController.php:336
* @route '/data_bayi/imunisasi/{id}'
*/
handleDeleteImunisasiForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleDeleteImunisasi.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

handleDeleteImunisasi.form = handleDeleteImunisasiForm

/**
* @see \App\Http\Controllers\BayiController::showKematianView
* @see app/Http/Controllers/BayiController.php:346
* @route '/data_bayi/kematian'
*/
export const showKematianView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showKematianView.url(options),
    method: 'get',
})

showKematianView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/kematian',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showKematianView
* @see app/Http/Controllers/BayiController.php:346
* @route '/data_bayi/kematian'
*/
showKematianView.url = (options?: RouteQueryOptions) => {
    return showKematianView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showKematianView
* @see app/Http/Controllers/BayiController.php:346
* @route '/data_bayi/kematian'
*/
showKematianView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showKematianView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showKematianView
* @see app/Http/Controllers/BayiController.php:346
* @route '/data_bayi/kematian'
*/
showKematianView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showKematianView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showKematianView
* @see app/Http/Controllers/BayiController.php:346
* @route '/data_bayi/kematian'
*/
const showKematianViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showKematianView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showKematianView
* @see app/Http/Controllers/BayiController.php:346
* @route '/data_bayi/kematian'
*/
showKematianViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showKematianView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showKematianView
* @see app/Http/Controllers/BayiController.php:346
* @route '/data_bayi/kematian'
*/
showKematianViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showKematianView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showKematianView.form = showKematianViewForm

/**
* @see \App\Http\Controllers\BayiController::showAddKematianView
* @see app/Http/Controllers/BayiController.php:362
* @route '/data_bayi/kematian/tambah'
*/
export const showAddKematianView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showAddKematianView.url(options),
    method: 'get',
})

showAddKematianView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/kematian/tambah',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showAddKematianView
* @see app/Http/Controllers/BayiController.php:362
* @route '/data_bayi/kematian/tambah'
*/
showAddKematianView.url = (options?: RouteQueryOptions) => {
    return showAddKematianView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showAddKematianView
* @see app/Http/Controllers/BayiController.php:362
* @route '/data_bayi/kematian/tambah'
*/
showAddKematianView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showAddKematianView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddKematianView
* @see app/Http/Controllers/BayiController.php:362
* @route '/data_bayi/kematian/tambah'
*/
showAddKematianView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showAddKematianView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showAddKematianView
* @see app/Http/Controllers/BayiController.php:362
* @route '/data_bayi/kematian/tambah'
*/
const showAddKematianViewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddKematianView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddKematianView
* @see app/Http/Controllers/BayiController.php:362
* @route '/data_bayi/kematian/tambah'
*/
showAddKematianViewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddKematianView.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showAddKematianView
* @see app/Http/Controllers/BayiController.php:362
* @route '/data_bayi/kematian/tambah'
*/
showAddKematianViewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showAddKematianView.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showAddKematianView.form = showAddKematianViewForm

/**
* @see \App\Http\Controllers\BayiController::handlePostKematian
* @see app/Http/Controllers/BayiController.php:372
* @route '/data_bayi/kematian'
*/
export const handlePostKematian = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handlePostKematian.url(options),
    method: 'post',
})

handlePostKematian.definition = {
    methods: ["post"],
    url: '/data_bayi/kematian',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\BayiController::handlePostKematian
* @see app/Http/Controllers/BayiController.php:372
* @route '/data_bayi/kematian'
*/
handlePostKematian.url = (options?: RouteQueryOptions) => {
    return handlePostKematian.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handlePostKematian
* @see app/Http/Controllers/BayiController.php:372
* @route '/data_bayi/kematian'
*/
handlePostKematian.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handlePostKematian.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handlePostKematian
* @see app/Http/Controllers/BayiController.php:372
* @route '/data_bayi/kematian'
*/
const handlePostKematianForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handlePostKematian.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handlePostKematian
* @see app/Http/Controllers/BayiController.php:372
* @route '/data_bayi/kematian'
*/
handlePostKematianForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handlePostKematian.url(options),
    method: 'post',
})

handlePostKematian.form = handlePostKematianForm

/**
* @see \App\Http\Controllers\BayiController::showEditKematianView
* @see app/Http/Controllers/BayiController.php:396
* @route '/data_bayi/kematian/{id}/edit'
*/
export const showEditKematianView = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showEditKematianView.url(args, options),
    method: 'get',
})

showEditKematianView.definition = {
    methods: ["get","head"],
    url: '/data_bayi/kematian/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::showEditKematianView
* @see app/Http/Controllers/BayiController.php:396
* @route '/data_bayi/kematian/{id}/edit'
*/
showEditKematianView.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return showEditKematianView.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::showEditKematianView
* @see app/Http/Controllers/BayiController.php:396
* @route '/data_bayi/kematian/{id}/edit'
*/
showEditKematianView.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showEditKematianView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditKematianView
* @see app/Http/Controllers/BayiController.php:396
* @route '/data_bayi/kematian/{id}/edit'
*/
showEditKematianView.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showEditKematianView.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::showEditKematianView
* @see app/Http/Controllers/BayiController.php:396
* @route '/data_bayi/kematian/{id}/edit'
*/
const showEditKematianViewForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditKematianView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditKematianView
* @see app/Http/Controllers/BayiController.php:396
* @route '/data_bayi/kematian/{id}/edit'
*/
showEditKematianViewForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditKematianView.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::showEditKematianView
* @see app/Http/Controllers/BayiController.php:396
* @route '/data_bayi/kematian/{id}/edit'
*/
showEditKematianViewForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: showEditKematianView.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

showEditKematianView.form = showEditKematianViewForm

/**
* @see \App\Http\Controllers\BayiController::handleUpdateKematian
* @see app/Http/Controllers/BayiController.php:403
* @route '/data_bayi/kematian/{id}'
*/
export const handleUpdateKematian = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: handleUpdateKematian.url(args, options),
    method: 'put',
})

handleUpdateKematian.definition = {
    methods: ["put"],
    url: '/data_bayi/kematian/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\BayiController::handleUpdateKematian
* @see app/Http/Controllers/BayiController.php:403
* @route '/data_bayi/kematian/{id}'
*/
handleUpdateKematian.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return handleUpdateKematian.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handleUpdateKematian
* @see app/Http/Controllers/BayiController.php:403
* @route '/data_bayi/kematian/{id}'
*/
handleUpdateKematian.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: handleUpdateKematian.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\BayiController::handleUpdateKematian
* @see app/Http/Controllers/BayiController.php:403
* @route '/data_bayi/kematian/{id}'
*/
const handleUpdateKematianForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleUpdateKematian.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handleUpdateKematian
* @see app/Http/Controllers/BayiController.php:403
* @route '/data_bayi/kematian/{id}'
*/
handleUpdateKematianForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleUpdateKematian.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

handleUpdateKematian.form = handleUpdateKematianForm

/**
* @see \App\Http\Controllers\BayiController::handleDeleteKematian
* @see app/Http/Controllers/BayiController.php:420
* @route '/data_bayi/kematian/{id}'
*/
export const handleDeleteKematian = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: handleDeleteKematian.url(args, options),
    method: 'delete',
})

handleDeleteKematian.definition = {
    methods: ["delete"],
    url: '/data_bayi/kematian/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\BayiController::handleDeleteKematian
* @see app/Http/Controllers/BayiController.php:420
* @route '/data_bayi/kematian/{id}'
*/
handleDeleteKematian.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return handleDeleteKematian.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::handleDeleteKematian
* @see app/Http/Controllers/BayiController.php:420
* @route '/data_bayi/kematian/{id}'
*/
handleDeleteKematian.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: handleDeleteKematian.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\BayiController::handleDeleteKematian
* @see app/Http/Controllers/BayiController.php:420
* @route '/data_bayi/kematian/{id}'
*/
const handleDeleteKematianForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleDeleteKematian.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::handleDeleteKematian
* @see app/Http/Controllers/BayiController.php:420
* @route '/data_bayi/kematian/{id}'
*/
handleDeleteKematianForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handleDeleteKematian.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

handleDeleteKematian.form = handleDeleteKematianForm

/**
* @see \App\Http\Controllers\BayiController::getBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
export const getBiodata = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getBiodata.url(options),
    method: 'get',
})

getBiodata.definition = {
    methods: ["get","head"],
    url: '/api/bayi/biodata',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::getBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
getBiodata.url = (options?: RouteQueryOptions) => {
    return getBiodata.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::getBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
getBiodata.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getBiodata.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
getBiodata.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getBiodata.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::getBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
const getBiodataForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getBiodata.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
getBiodataForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getBiodata.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
getBiodataForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getBiodata.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

getBiodata.form = getBiodataForm

/**
* @see \App\Http\Controllers\BayiController::postBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
export const postBiodata = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: postBiodata.url(options),
    method: 'post',
})

postBiodata.definition = {
    methods: ["post"],
    url: '/api/bayi/biodata',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\BayiController::postBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
postBiodata.url = (options?: RouteQueryOptions) => {
    return postBiodata.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::postBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
postBiodata.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: postBiodata.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::postBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
const postBiodataForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: postBiodata.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::postBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata'
*/
postBiodataForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: postBiodata.url(options),
    method: 'post',
})

postBiodata.form = postBiodataForm

/**
* @see \App\Http\Controllers\BayiController::updateBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
export const updateBiodata = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateBiodata.url(args, options),
    method: 'put',
})

updateBiodata.definition = {
    methods: ["put"],
    url: '/api/bayi/biodata/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\BayiController::updateBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
updateBiodata.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return updateBiodata.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::updateBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
updateBiodata.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateBiodata.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\BayiController::updateBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
const updateBiodataForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateBiodata.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::updateBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
updateBiodataForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateBiodata.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateBiodata.form = updateBiodataForm

/**
* @see \App\Http\Controllers\BayiController::deleteBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
export const deleteBiodata = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteBiodata.url(args, options),
    method: 'delete',
})

deleteBiodata.definition = {
    methods: ["delete"],
    url: '/api/bayi/biodata/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\BayiController::deleteBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
deleteBiodata.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return deleteBiodata.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::deleteBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
deleteBiodata.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteBiodata.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\BayiController::deleteBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
const deleteBiodataForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteBiodata.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\BayiController::deleteBiodata
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/biodata/{id}'
*/
deleteBiodataForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteBiodata.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

deleteBiodata.form = deleteBiodataForm

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/penimbangan'
*/
export const getPenimbangan = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getPenimbangan.url(options),
    method: 'get',
})

getPenimbangan.definition = {
    methods: ["get","head"],
    url: '/api/bayi/penimbangan',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/penimbangan'
*/
getPenimbangan.url = (options?: RouteQueryOptions) => {
    return getPenimbangan.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/penimbangan'
*/
getPenimbangan.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getPenimbangan.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/penimbangan'
*/
getPenimbangan.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getPenimbangan.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/penimbangan'
*/
const getPenimbanganForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getPenimbangan.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/penimbangan'
*/
getPenimbanganForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getPenimbangan.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/penimbangan'
*/
getPenimbanganForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getPenimbangan.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

getPenimbangan.form = getPenimbanganForm

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/imunisasi'
*/
export const getImunisasi = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getImunisasi.url(options),
    method: 'get',
})

getImunisasi.definition = {
    methods: ["get","head"],
    url: '/api/bayi/imunisasi',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/imunisasi'
*/
getImunisasi.url = (options?: RouteQueryOptions) => {
    return getImunisasi.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/imunisasi'
*/
getImunisasi.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getImunisasi.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/imunisasi'
*/
getImunisasi.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getImunisasi.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/imunisasi'
*/
const getImunisasiForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getImunisasi.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/imunisasi'
*/
getImunisasiForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getImunisasi.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/imunisasi'
*/
getImunisasiForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getImunisasi.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

getImunisasi.form = getImunisasiForm

/**
* @see \App\Http\Controllers\BayiController::getKematian
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/kematian'
*/
export const getKematian = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getKematian.url(options),
    method: 'get',
})

getKematian.definition = {
    methods: ["get","head"],
    url: '/api/bayi/kematian',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::getKematian
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/kematian'
*/
getKematian.url = (options?: RouteQueryOptions) => {
    return getKematian.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::getKematian
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/kematian'
*/
getKematian.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getKematian.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getKematian
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/kematian'
*/
getKematian.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getKematian.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\BayiController::getKematian
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/kematian'
*/
const getKematianForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getKematian.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getKematian
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/kematian'
*/
getKematianForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getKematian.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BayiController::getKematian
* @see app/Http/Controllers/BayiController.php:0
* @route '/api/bayi/kematian'
*/
getKematianForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: getKematian.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

getKematian.form = getKematianForm

const BayiController = { showBiodataView, showAddBiodataView, handlePostBiodata, showEditBiodataView, handleUpdateBiodata, handleDeleteBiodata, showPenimbanganView, showAddPenimbanganView, handlePostPenimbangan, showEditPenimbanganView, handleUpdatePenimbangan, handleDeletePenimbangan, showImunisasiView, showAddImunisasiView, handlePostImunisasi, showEditImunisasiView, handleUpdateImunisasi, handleDeleteImunisasi, showKematianView, showAddKematianView, handlePostKematian, showEditKematianView, handleUpdateKematian, handleDeleteKematian, getBiodata, postBiodata, updateBiodata, deleteBiodata, getPenimbangan, getImunisasi, getKematian }

export default BayiController