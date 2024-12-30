import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";
import { Input, Checkbox, Button, Typography } from "@material-tailwind/react";

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("login"), {
            onFinish: () => reset("password"),
        });
    };

    return (
        <>
            <Head title="Sign In" />
            <section className="m-8 flex gap-4">
                <div className="w-full lg:w-3/5 mt-24">
                    <div className="text-center">
                        <Typography variant="h2" className="font-bold mb-4">
                            Sign In
                        </Typography>
                        <Typography
                            variant="paragraph"
                            color="blue-gray"
                            className="text-lg font-normal"
                        >
                            Enter your email and password to Sign In.
                        </Typography>
                    </div>
                    <form
                        className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2"
                        onSubmit={submit}
                    >
                        <div className="mb-1 flex flex-col gap-6">
                            <Typography
                                variant="small"
                                color="blue-gray"
                                className="-mb-3 font-medium"
                            >
                                Your email
                            </Typography>
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full"
                                autoComplete="username"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                            />
                            <Typography
                                variant="small"
                                color="blue-gray"
                                className="-mb-3 font-medium"
                            >
                                Password
                            </Typography>
                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full"
                                autoComplete="current-password"
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                            />
                        </div>

                        <div className="flex items-center justify-between gap-2 ">
                            <Checkbox
                                label={
                                    <Typography
                                        variant="small"
                                        color="gray"
                                        className="flex items-center justify-start font-medium"
                                    >
                                        I agree the&nbsp;
                                        <a
                                            href="#"
                                            className="font-normal text-black transition-colors hover:text-gray-900 underline"
                                        >
                                            Terms and Conditions
                                        </a>
                                    </Typography>
                                }
                                containerProps={{ className: "-ml-2.5" }}
                            />
                            <Typography
                                variant="small"
                                className="font-medium text-gray-900"
                            >
                                <a href="#">Forgot Password</a>
                            </Typography>
                        </div>
                        <Button className="mt-6" fullWidth type="submit">
                            Sign In
                        </Button>
                        <Typography
                            variant="paragraph"
                            className="text-center text-blue-gray-500 font-medium mt-4"
                        >
                            Not registered?
                            <Link
                                href="/register"
                                className="text-gray-900 ml-1"
                            >
                                Create account
                            </Link>
                        </Typography>
                    </form>
                </div>
                <div className="w-2/5 h-full hidden lg:block">
                    <img
                        src="/images/pattern.png"
                        className="h-full w-full object-cover rounded-3xl"
                    />
                </div>
            </section>
        </>
    );
}
