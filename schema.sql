-- Schema::create('users', function (Blueprint $table) {
--             $table->id();
--             $table->string('name');
--             $table->string('email')->unique();
--             $table->timestamp('email_verified_at')->nullable();
--             $table->string('password');
--             $table->rememberToken();
--             $table->timestamps();
--         });
Schema::create('projects', function (Blueprint $table) { 
$table->id();
$table->string('title');
$table->text('description')->nullable(); 
$table->date('deadline')->nullable();
$table->enum('status', ['planning', 'active', 'on_hold', 'completed'])->default('planning');
$table->timestamps();
$table->softDeletes();
});


Schema::create('members', function (Blueprint $table) {
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->enum('role', ['lead', 'developer']);
    $table->timestamps();
    $table->primary(['project_id', 'user_id']);
});


Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
    $table->string('title');
    $table->text('description')->nullable();
    $table->date('deadline')->nullable();
    $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
    $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
    $table->timestamps();
});
