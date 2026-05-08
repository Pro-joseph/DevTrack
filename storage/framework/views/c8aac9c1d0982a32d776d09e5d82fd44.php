<?php $__env->startSection('title', $project->title . ' | DevTrack'); ?>
<?php $__env->startSection('page-title', $project->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto space-y-10 animate-in fade-in duration-700">
        <section>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span
                            class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                            <?php echo e(ucfirst($project->status)); ?>

                        </span>
                        <span class="text-outline font-bold text-xs uppercase tracking-tighter tracking-widest">Project
                            #<?php echo e($project->id); ?></span>
                    </div>
                    <h2 class="text-4xl font-black text-on-surface tracking-tight"><?php echo e($project->title); ?></h2>
                    <p class="text-on-surface-variant max-w-2xl text-base leading-relaxed">
                        <?php echo e($project->description ?? 'No description provided.'); ?>

                    </p>
                </div>
                <div class="flex flex-col items-start md:items-end gap-4">
                    <div class="flex items-center gap-2 text-outline font-bold text-xs uppercase tracking-widest">
                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                        Deadline: <span
                            class="text-on-surface"><?php echo e($project->deadline ? \date('M d, Y', \strtotime($project->deadline)) : 'Not set'); ?></span>
                    </div>
                    <div class="flex gap-3">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $project)): ?>
                            <form action="<?php echo e(route('projects.archive', $project->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="bg-white border border-outline-variant text-on-surface px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-surface-container-low transition-all flex items-center gap-2"
                                    onclick="return confirm('Archive this project?')">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                    Delete
                                </button>
                            </form>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $project)): ?>
                            <a href="<?php echo e(route('projects.edit', $project)); ?>"
                                class="bg-white border border-outline-variant text-on-surface px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-surface-container-low transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                Edit
                            </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', $project)): ?>
                            <a href="<?php echo e(route('tasks.create', $project)); ?>"
                                class="bg-primary text-white px-5 py-2.5 rounded-lg font-bold text-sm hover:shadow-lg hover:bg-primary-container transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                                New Task
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <div class="p-8 bg-white border border-outline-variant rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-1 h-full bg-primary"></div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm font-bold text-on-surface uppercase tracking-wider">Overall Project Progress</span>
                <span
                    class="text-xl font-black text-primary"><?php echo e($project->tasks->count() > 0 ? round(($project->tasks->where('status', 'done')->count() / $project->tasks->count()) * 100) : 0); ?>%</span>
            </div>
            <div class="w-full bg-surface-container-high rounded-full h-3">
                <div class="bg-primary h-full rounded-full transition-all duration-1000 ease-out"
                    style="width: <?php echo e($project->tasks->count() > 0 ? ($project->tasks->where('status', 'done')->count() / $project->tasks->count()) * 100 : 0); ?>%">
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 pt-6 animate-in fade-in duration-700">
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-on-surface">Open Tasks</h3>
                <span
                    class="bg-primary/5 text-primary px-3 py-1 rounded-full text-xs font-bold"><?php echo e($project->tasks->where('status', '!=', 'done')->count()); ?>

                    Remaining</span>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $project->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div
                    class="bg-white border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md hover:translate-x-1 transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <div class="space-y-3">
                            <a href="<?php echo e(route('tasks.edit', [$project, $task])); ?>"
                                class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">
                                <?php echo e($task->title); ?>

                            </a>
                            <div class="flex flex-wrap gap-2">
                                <?php if($task->priority): ?>
                                    <span
                                        class="<?php echo e($task->priority === 'high' ? 'bg-error/10 text-error' : ($task->priority === 'medium' ? 'bg-tertiary/10 text-tertiary' : 'bg-surface-container text-outline')); ?> px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                        <?php echo e($task->priority); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $task)): ?>
                        <a href="<?php echo e(route('tasks.edit', [$project, $task])); ?>"
                            class="text-outline hover:text-primary transition-colors p-1">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $task)): ?>
                        <form action="<?php echo e(route('tasks.destroy-simple', $task)); ?>" method="POST" class="inline" onclick="event.stopPropagation()">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-outline hover:text-error transition-colors p-1" onclick="return confirm('Delete this task?')">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center justify-between border-t border-outline-variant/30 pt-4">
                        <div class="flex items-center gap-2">
                            <?php if($task->assignee): ?>
                                <img class="h-8 w-8 rounded-full border-2 border-white ring-1 ring-outline-variant"
                                    src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($task->assignee->name)); ?>"
                                    alt="<?php echo e($task->assignee->name); ?>">
                                <span class="text-sm font-bold text-on-surface"><?php echo e($task->assignee->name); ?></span>
                            <?php else: ?>
                                <div
                                    class="h-8 w-8 rounded-full border-2 border-white bg-surface-container flex items-center justify-center text-[10px] font-bold text-outline ring-1 ring-outline-variant">
                                    ?</div>
                                <span class="text-sm text-outline">Unassigned</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-4">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('updateStatus', $task)): ?>
                            <form action="<?php echo e(route('tasks.updateStatus', [$project, $task])); ?>" method="POST" class="inline" onsubmit="this.querySelector('select').disabled = false;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <select name="status" onchange="this.form.submit()" class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest cursor-pointer border-none">
                                    <option value="todo" <?php echo e($task->status == 'todo' ? 'selected' : ''); ?>>To Do</option>
                                    <option value="in_progress" <?php echo e($task->status == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                                    <option value="done" <?php echo e($task->status == 'done' ? 'selected' : ''); ?>>Done</option>
                                </select>
                            </form>
                            <?php else: ?>
                            <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest"><?php echo e($task->status); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-white border border-outline-variant p-8 rounded-xl text-center">
                    <div
                        class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center text-outline mb-4 mx-auto">
                        <span class="material-symbols-outlined text-4xl">assignment</span>
                    </div>
                    <p class="text-on-surface font-bold">No tasks yet</p>
                    <p class="text-sm text-outline mt-2">Create your first task to get started.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="space-y-8 pt-6">
            <section class="bg-white border border-outline-variant p-8 rounded-2xl shadow-sm space-y-6">
                <h3 class="text-sm font-bold text-on-surface uppercase tracking-widest border-b border-outline-variant pb-4 ">
                    Quick Summary
                </h3>
                <div class="space-y-6">
                    <div>
                        <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Owner</div>
                        <div class="text-sm font-bold text-on-surface"><?php echo e($project->owner->name ?? 'Unknown'); ?></div>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Tasks</div>
                            <div class="text-2xl font-black text-on-surface"><?php echo e($project->tasks->count()); ?></div>
                        </div>
                        <div>
                            <div class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Done</div>
                            <div class="text-2xl font-black text-primary">
                                <?php echo e($project->tasks->where('status', 'done')->count()); ?></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white border border-outline-variant p-8 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold text-on-surface uppercase tracking-widest">Team</h3>
                    <a href="<?php echo e(route('projects.members.index', $project)); ?>"
                        class="text-primary text-[10px] font-bold uppercase tracking-widest hover:underline">Manage</a>
                </div>
                <div class="space-y-5">
                    <?php $__empty_1 = true; $__currentLoopData = $project->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between group cursor-pointer">
                            <div class="flex items-center gap-3">
                                <img class="w-10 h-10 rounded-full border border-outline-variant shadow-sm group-hover:ring-2 group-hover:ring-primary/20 transition-all"
                                    src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($member->name)); ?>"
                                    alt="<?php echo e($member->name); ?>">
                                <div>
                                    <div
                                        class="text-sm font-bold text-on-surface group-hover:text-primary transition-colors">
                                        <?php echo e($member->name); ?></div>
                                    <div class="text-[10px] text-outline font-medium">
                                        <?php echo e($member->pivot->role ?? 'Member'); ?></div>
                                </div>
                            </div>
                            <button class="text-outline hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[20px]">mail</span>
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-outline">No team members</p>
                    <?php endif; ?>
                </div>
                <a href="<?php echo e(route('team.index')); ?>">
                    <button
                        class="w-full mt-8 py-3 border-2 border-dashed border-outline-variant rounded-xl text-outline font-bold text-[10px] uppercase tracking-widest hover:border-primary hover:text-primary hover:bg-primary/5 transition-all flex items-center justify-center gap-2 group">
                        <span
                            class="material-symbols-outlined text-sm group-hover:rotate-90 transition-transform">person_add</span>
                        Invite Member
                    </button>
                </a>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\devtrack\resources\views/projects/show.blade.php ENDPATH**/ ?>