<?php $__env->startSection('title', 'Tasks | DevTrack'); ?>
<?php $__env->startSection('page-title', 'Tasks'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 animate-in fade-in duration-500">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-on-surface">My Tasks</h2>
                <p class="text-sm text-outline mt-1">You have <?php echo e($tasks->count()); ?> tasks across all projects</p>
            </div>
        </div>

        <!-- Task Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white border border-outline-variant rounded-xl p-4">
                <div class="text-2xl font-black text-primary"><?php echo e($tasks->count()); ?></div>
                <div class="text-xs text-outline font-bold uppercase tracking-wider">Total</div>
            </div>
            <div class="bg-white border border-outline-variant rounded-xl p-4">
                <div class="text-2xl font-black text-on-surface"><?php echo e($tasks->where('status', 'todo')->count()); ?></div>
                <div class="text-xs text-outline font-bold uppercase tracking-wider">To Do</div>
            </div>
            <div class="bg-white border border-outline-variant rounded-xl p-4">
                <div class="text-2xl font-black text-primary"><?php echo e($tasks->where('status', 'in_progress')->count()); ?></div>
                <div class="text-xs text-outline font-bold uppercase tracking-wider">In Progress</div>
            </div>
            <div class="bg-white border border-outline-variant rounded-xl p-4">
                <div class="text-2xl font-black text-secondary"><?php echo e($tasks->where('status', 'done')->count()); ?></div>
                <div class="text-xs text-outline font-bold uppercase tracking-wider">Done</div>
            </div>
        </div>

        <!-- Task List -->
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white border border-outline-variant rounded-xl p-4 hover:shadow-md transition-all cursor-pointer flex items-center gap-4 task-row"
                     data-task-id="<?php echo e($task->id); ?>"
                     data-task-title="<?php echo e($task->title); ?>"
                     data-task-description="<?php echo e($task->description ?? ''); ?>"
                     data-task-priority="<?php echo e($task->priority); ?>"
                     data-task-status="<?php echo e($task->status); ?>"
                     data-task-deadline="<?php echo e($task->deadline ?? ''); ?>"
                     data-project-title="<?php echo e($task->project->title ?? 'No Project'); ?>"
                      data-user-name="<?php echo e($task->assignee->name ?? 'Unassigned'); ?>">

                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-on-surface truncate"><?php echo e($task->title); ?></h4>
                        <p class="text-xs text-outline truncate"><?php echo e($task->project->title ?? 'No Project'); ?></p>
                    </div>

                    <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded
                        <?php echo e($task->priority === 'high' ? 'bg-error/10 text-error' : ($task->priority === 'medium' ? 'bg-primary/10 text-primary' : 'bg-surface-container text-outline')); ?>">
                        <?php echo e($task->priority); ?>

                    </span>

                    <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded whitespace-nowrap
                        <?php echo e($task->status === 'done' ? 'bg-secondary/10 text-secondary' : ($task->status === 'in_progress' ? 'bg-primary/10 text-primary' : 'bg-surface-container text-outline')); ?>">
                        <?php echo e(str_replace('_', ' ', $task->status)); ?>

                    </span>

                    <div class="flex items-center gap-2 text-xs text-outline">
                        <span class="material-symbols-outlined text-sm">person</span>
                        <?php echo e($task->assignee->name ?? 'Unassigned'); ?>

                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('updateStatus', $task)): ?>
                    <form action="<?php echo e(route('tasks.updateStatus', [$task->project, $task])); ?>" method="POST" class="inline" onclick="event.stopPropagation()">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <select name="status" onchange="this.form.submit()" class="text-xs border border-outline-variant rounded px-2 py-1 bg-white cursor-pointer">
                            <option value="todo" <?php echo e(old('status', $task->status) == 'todo' ? 'selected' : ''); ?>>To Do</option>
                            <option value="in_progress" <?php echo e(old('status', $task->status) == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                            <option value="done" <?php echo e(old('status', $task->status) == 'done' ? 'selected' : ''); ?>>Done</option>
                        </select>
                    </form>
                    <?php endif; ?>


                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $task)): ?>
                    <form action="<?php echo e(route('tasks.destroy-simple', $task)); ?>" method="POST" class="inline" onclick="event.stopPropagation()">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-outline hover:text-error p-2" onclick="return confirm('Delete this task?')">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </form>
                    <?php endif; ?>

                    <button type="button" class="text-outline hover:text-primary p-2" onclick="event.stopPropagation()">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                    </button>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-8 text-outline">
                    No tasks found. <a href="<?php echo e(isset($project) ? route('tasks.create', $project) : route('dashboard')); ?>" class="text-primary hover:underline">Create one</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Task Detail Modal -->
    <div id="taskModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50" onclick="closeTaskModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 mx-4">
            <button type="button" onclick="closeTaskModal()" class="absolute top-4 right-4 text-outline hover:text-on-surface">
                <span class="material-symbols-outlined">close</span>
            </button>

            <h3 id="modalTitle" class="text-xl font-bold text-on-surface mb-4"></h3>

            <div class="space-y-4">
                <div>
                    <label class="text-xs font-bold uppercase text-outline">Description</label>
                    <p id="modalDescription" class="text-sm text-on-surface mt-1"></p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Project</label>
                        <p id="modalProject" class="text-sm text-on-surface mt-1"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Assigned To</label>
                        <p id="modalUser" class="text-sm text-on-surface mt-1"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Priority</label>
                        <p id="modalPriority" class="text-sm text-on-surface mt-1 capitalize"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Status</label>
                        <p id="modalStatus" class="text-sm text-on-surface mt-1 capitalize"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-outline">Deadline</label>
                        <p id="modalDeadline" class="text-sm text-on-surface mt-1"></p>
                    </div>
</div>
                </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.task-row').forEach(row => {
            row.addEventListener('click', function() {
                const modal = document.getElementById('taskModal');
                document.getElementById('modalTitle').textContent = this.dataset.taskTitle;
                document.getElementById('modalDescription').textContent = this.dataset.taskDescription || 'No description';
                document.getElementById('modalProject').textContent = this.dataset.projectTitle;
                document.getElementById('modalUser').textContent = this.dataset.userName;
                document.getElementById('modalPriority').textContent = this.dataset.taskPriority;
                document.getElementById('modalStatus').textContent = this.dataset.taskStatus.replace('_', ' ');
                
                if (this.dataset.taskDeadline) {
                    const date = new Date(this.dataset.taskDeadline);
                    document.getElementById('modalDeadline').textContent = date.toLocaleDateString();
                } else {
                    document.getElementById('modalDeadline').textContent = 'No deadline';
                }

                
                
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            });
        });

        function closeTaskModal() {
            const modal = document.getElementById('taskModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\devtrack\resources\views/tasks/index.blade.php ENDPATH**/ ?>