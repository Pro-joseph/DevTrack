<?php
$isEdit = isset($task) && $task;
$formAction = $isEdit ? route('tasks.update', [$project, $task]) : route('tasks.store', $project);
$method = $isEdit ? 'PUT' : 'POST';
$canFullUpdate = $isEdit ? (isset($canFullUpdate) && $canFullUpdate) : true;
$canUpdate = $isEdit ? (isset($canUpdate) && $canUpdate) : true;
?>

<?php $__env->startSection('title', $isEdit ? 'Edit Task | DevTrack' : 'New Task | DevTrack'); ?>
<?php $__env->startSection('page-title', $isEdit ? 'Edit Task' : 'New Task'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto bg-white border border-outline-variant shadow-sm rounded-xl overflow-hidden animate-in fade-in zoom-in-95 duration-500">
    <div class="px-8 py-6 border-b border-outline-variant flex items-center justify-between bg-surface-container-low/50">
        <div>
            <h1 class="text-2xl font-bold text-on-surface"><?php echo e($isEdit ? 'Edit Task' : 'Define Task'); ?></h1>
            <p class="text-sm text-on-surface-variant"><?php echo e($isEdit ? 'Update task details.' : 'Define task requirements.'); ?></p>
        </div>
        <a href="<?php echo e(isset($project) ? route('projects.show', $project) : route('tasks.index')); ?>" class="text-on-surface-variant hover:bg-surface-container rounded-full p-2 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </a>
    </div>

    <form action="<?php echo e($formAction); ?>" method="POST" class="p-8 space-y-8">
        <?php echo csrf_field(); ?>
        <?php if($isEdit): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            <div class="md:col-span-7 space-y-8">
<?php if($canFullUpdate || !$isEdit): ?>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="project_id">Project</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        <?php echo e($project->title ?? 'No Project'); ?>

                    </div>
                    <input type="hidden" name="project_id" value="<?php echo e($project->id); ?>">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="title">Task Title</label>
                    <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                           id="title" name="title" placeholder="e.g., Implement Authentication Flow" type="text" value="<?php echo e($isEdit ? $task->title : old('title')); ?>" <?php echo e(!$canFullUpdate && $isEdit ? 'readonly' : 'required'); ?>/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="description">Description</label>
                    <textarea class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all resize-none bg-surface/50" 
                              id="description" name="description" placeholder="Detail the technical requirements and scope..." rows="6" <?php echo e(!$canUpdate && $isEdit ? 'readonly' : ''); ?>><?php echo e($isEdit ? $task->description : old('description')); ?></textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="deadline">Deadline</label>
                        <input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all bg-surface/50" 
                               id="deadline" name="deadline" type="date" value="<?php echo e($isEdit ? $task->deadline : old('deadline')); ?>" <?php echo e(!$canUpdate && $isEdit ? 'readonly' : ''); ?>/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="priority">Priority</label>
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="priority" name="priority" <?php echo e(!$canUpdate && $isEdit ? 'disabled' : ''); ?>>
                            <option value="low" <?php echo e($isEdit && $task->priority == 'low' ? 'selected' : ''); ?>>Low</option>
                            <option value="medium" <?php echo e(($isEdit && $task->priority == 'medium') || (!$isEdit) ? 'selected' : ''); ?>>Medium</option>
                            <option value="high" <?php echo e($isEdit && $task->priority == 'high' ? 'selected' : ''); ?>>High</option>
                        </select>
                    </div>
                </div>
                <?php else: ?>
                <input type="hidden" name="project_id" value="<?php echo e($task->project_id); ?>">
                <input type="hidden" name="title" value="<?php echo e($task->title); ?>">
                <input type="hidden" name="description" value="<?php echo e($task->description); ?>">
                <input type="hidden" name="deadline" value="<?php echo e($task->deadline); ?>">
                <input type="hidden" name="priority" value="<?php echo e($task->priority); ?>">

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Project</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        <?php echo e($task->project->title ?? 'No Project'); ?>

                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Task Title</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        <?php echo e($task->title); ?>

                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Description</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        <?php echo e($task->description ?? 'No description'); ?>

                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Deadline</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        <?php echo e($task->deadline ? \date('M d, Y', \strtotime($task->deadline)) : 'Not set'); ?>

                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Priority</label>
                    <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                        <?php echo e(ucfirst($task->priority)); ?>

                    </div>
                </div>
                <?php endif; ?>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-on-surface uppercase tracking-wider" for="status">Status</label>
                    <?php if($isEdit): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['update', 'updateStatus'], $task)): ?>
                        <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="status" name="status">
                            <option value="todo" <?php echo e(old('status', $task->status) == 'todo' ? 'selected' : ''); ?>>To Do</option>
                            <option value="in_progress" <?php echo e(old('status', $task->status) == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                            <option value="done" <?php echo e(old('status', $task->status) == 'done' ? 'selected' : ''); ?>>Done</option>
                        </select>
                        <?php else: ?>
                        <div class="w-full border border-outline-variant rounded-lg text-sm py-3 px-4 bg-surface-container-low text-on-surface">
                            <?php echo e($task->status); ?>

                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                    <select class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-sm py-3 px-4 transition-all appearance-none bg-surface/50" id="status" name="status">
                        <option value="todo" <?php echo e(old('status', 'todo') == 'todo' ? 'selected' : ''); ?>>To Do</option>
                        <option value="in_progress" <?php echo e(old('status') == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                        <option value="done" <?php echo e(old('status') == 'done' ? 'selected' : ''); ?>>Done</option>
                    </select>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($canUpdate || !$isEdit): ?>
            <div class="md:col-span-5 flex flex-col gap-2">
                <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Assign Team</label>
                <div class="border border-outline-variant rounded-lg overflow-hidden bg-surface-container-lowest flex-1 flex flex-col">
                    <div class="p-3 bg-surface-container-low border-b border-outline-variant relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">search</span>
                        <input class="w-full pl-8 pr-4 py-1 text-xs bg-transparent border-none focus:ring-0" placeholder="Search team members..." type="text"/>
                    </div>
                    <div class="flex-1 overflow-y-auto divide-y divide-outline-variant">
                        <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="flex items-center gap-3 p-4 hover:bg-surface-container-low transition-colors cursor-pointer group <?php echo e($isEdit && $task->assigned_to == $member->id ? 'bg-primary/5' : ''); ?>">
                                <input class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary" type="radio" name="assigned_to" value="<?php echo e($member->id); ?>" <?php echo e($isEdit && isset($task->assigned_to) && $task->assigned_to == $member->id ? 'checked' : ''); ?>/>
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                    <?php echo e(substr($member->name, 0, 1)); ?>

                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-on-surface"><?php echo e($member->name); ?></p>
                                    <p class="text-xs text-on-surface-variant"><?php echo e($member->email); ?></p>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-4 text-center text-outline text-sm">No members available</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php elseif($isEdit && $task->user_id): ?>
            <div class="md:col-span-5 flex flex-col gap-2">
                <label class="text-sm font-bold text-on-surface uppercase tracking-wider">Assigned To</label>
                <div class="border border-outline-variant rounded-lg p-4 bg-surface-container-low">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                            <?php echo e(substr($task->user->name, 0, 1)); ?>

                        </div>
                        <div>
                            <p class="text-sm font-bold text-on-surface"><?php echo e($task->user->name); ?></p>
                            <p class="text-xs text-on-surface-variant"><?php echo e($task->user->email); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="pt-8 border-t border-outline-variant flex items-center justify-end gap-4">
            <a href="<?php echo e(isset($project) ? route('projects.show', $project) : route('tasks.index')); ?>" class="px-6 py-2.5 text-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-all">
                Cancel
            </a>
            <button class="bg-primary hover:bg-primary-container text-white px-8 py-2.5 text-sm font-bold rounded-lg shadow-sm active:scale-95 transition-all flex items-center gap-2" type="submit">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <?php echo e($isEdit ? 'Update Task' : 'Save Task'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\devtrack\resources\views/tasks/edit.blade.php ENDPATH**/ ?>